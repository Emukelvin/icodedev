<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Notifications\NewMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = auth()->user()->conversations()
            ->with(['latestMessage.user', 'participants'])
            ->latest('updated_at')
            ->paginate(20);

        return view('client.messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        if (!$conversation->participants()->where('user_id', auth()->id())->exists()) {
            abort(403);
        }

        $messages = $conversation->messages()->with('user')->oldest()->get();

        $conversation->participants()->updateExistingPivot(auth()->id(), [
            'last_read_at' => now(),
        ]);

        return view('client.messages.show', compact('conversation', 'messages'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        if (!$conversation->participants()->where('user_id', auth()->id())->exists()) {
            abort(403);
        }

        $request->validate([
            'body' => 'required|string|max:5000',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $data = [
            'conversation_id' => $conversation->id,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $data['attachment'] = $file->store('message-attachments', 'public');
            $data['attachment_name'] = $file->getClientOriginalName();
        }

        $message = Message::create($data);
        $conversation->touch();

        // Notify other participants
        $message->load('user');
        foreach ($conversation->participants as $participant) {
            if ($participant->id !== auth()->id()) {
                $participant->notify(new NewMessage($message));
            }
        }

        return back();
    }

    public function create()
    {
        return view('client.messages.create');
    }

    public function startConversation(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string|max:5000',
        ]);

        $conversation = Conversation::create([
            'subject' => $request->subject,
            'type' => 'support',
        ]);

        $conversation->participants()->attach(auth()->id());

        $admins = \App\Models\User::where('role', 'admin')->pluck('id');
        $conversation->participants()->attach($admins);

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return redirect()->route('client.messages.show', $conversation)
            ->with('success', 'Conversation started.');
    }
}
