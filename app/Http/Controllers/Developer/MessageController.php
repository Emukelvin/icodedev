<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
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

        return view('developer.messages.index', compact('conversations'));
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

        return view('developer.messages.show', compact('conversation', 'messages'));
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
        try {
            foreach ($conversation->participants as $participant) {
                if ($participant->id !== auth()->id()) {
                    $participant->notify(new NewMessage($message));
                }
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return back();
    }

    public function create()
    {
        $users = User::whereIn('role', ['admin', 'manager', 'client'])
            ->where('id', '!=', auth()->id())
            ->orderBy('name')
            ->get();

        return view('developer.messages.create', compact('users'));
    }

    public function startConversation(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string|max:5000',
        ]);

        $conversation = Conversation::create([
            'subject' => $request->subject,
            'type' => 'direct',
        ]);

        $conversation->participants()->attach([auth()->id(), $request->recipient_id]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        $recipient = User::find($request->recipient_id);
        $message->load('user');
        try {
            $recipient->notify(new NewMessage($message));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('developer.messages.show', $conversation)
            ->with('success', 'Conversation started.');
    }
}
