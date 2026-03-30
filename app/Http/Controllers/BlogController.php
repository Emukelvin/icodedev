<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::published()->with(['author', 'category', 'tags']);

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%"));
        }

        $posts = $query->latest('published_at')->paginate(9);
        $categories = BlogCategory::where('is_active', true)->withCount(['posts' => fn($q) => $q->published()])->get();
        $tags = BlogTag::withCount('posts')->orderByDesc('posts_count')->take(20)->get();
        $featuredPosts = BlogPost::with('author', 'category')->published()->latest('published_at')->take(5)->get();

        return view('pages.blog.index', compact('posts', 'categories', 'tags', 'featuredPosts'));
    }

    public function show(BlogPost $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }

        $post->increment('views_count');
        $post->load(['author', 'category', 'tags', 'comments.user', 'comments.replies.user']);

        $related = BlogPost::with('author', 'category')->published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest('published_at')->take(3)->get();

        $previousPost = BlogPost::published()
            ->where('published_at', '<', $post->published_at)
            ->latest('published_at')->first();

        $nextPost = BlogPost::published()
            ->where('published_at', '>', $post->published_at)
            ->oldest('published_at')->first();

        return view('pages.blog.show', compact('post', 'related', 'previousPost', 'nextPost'));
    }

    public function storeComment(Request $request, BlogPost $post)
    {
        // Honeypot anti-spam
        if ($request->filled('website_url')) {
            return back()->with('success', 'Comment posted successfully!');
        }

        $rules = [
            'body' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:blog_comments,id',
        ];

        if (!auth()->check()) {
            $rules['guest_name'] = 'required|string|max:255';
            $rules['guest_email'] = 'required|email|max:255';
        }

        $validated = $request->validate($rules);

        $post->allComments()->create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
            'parent_id' => $validated['parent_id'] ?? null,
            'guest_name' => auth()->check() ? null : $validated['guest_name'],
            'guest_email' => auth()->check() ? null : $validated['guest_email'],
            'is_approved' => auth()->check(),
        ]);

        return back()->with('success', auth()->check()
            ? 'Comment posted successfully!'
            : 'Comment submitted and awaiting moderation.');
    }
}
