<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('author', 'category')->latest()->paginate(20);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::where('is_active', true)->get();
        $tags = BlogTag::all();
        $post = new BlogPost;
        return view('admin.blog.form', compact('post', 'categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:blog_categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'tags' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        unset($validated['tags']);
        $post = BlogPost::create($validated);

        if ($request->filled('tags')) {
            $tagIds = [];
            foreach ($request->tags as $tagName) {
                $tag = BlogTag::firstOrCreate(
                    ['slug' => Str::slug($tagName)],
                    ['name' => $tagName]
                );
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post created successfully.');
    }

    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::where('is_active', true)->get();
        $tags = BlogTag::all();
        return view('admin.blog.form', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:blog_categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'tags' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if ($validated['status'] === 'published' && !$post->published_at) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        unset($validated['tags']);
        $post->update($validated);

        if ($request->has('tags')) {
            $tagIds = [];
            foreach ($request->tags ?? [] as $tagName) {
                $tag = BlogTag::firstOrCreate(
                    ['slug' => Str::slug($tagName)],
                    ['name' => $tagName]
                );
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(BlogPost $post)
    {
        $post->delete();
        return redirect()->route('admin.blog.index')
            ->with('success', 'Post deleted.');
    }

    public function categories()
    {
        $categories = BlogCategory::withCount('posts')->get();
        return view('admin.blog.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        BlogCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return back()->with('success', 'Category created.');
    }

    public function deleteCategory(BlogCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    // Comments moderation
    public function comments(Request $request)
    {
        $query = BlogComment::with('post', 'user');

        if ($request->filled('status')) {
            $query->where('is_approved', $request->status === 'approved');
        }

        $comments = $query->latest()->paginate(30);
        return view('admin.blog.comments', compact('comments'));
    }

    public function approveComment(BlogComment $comment)
    {
        $comment->update(['is_approved' => true]);
        return back()->with('success', 'Comment approved.');
    }

    public function rejectComment(BlogComment $comment)
    {
        $comment->update(['is_approved' => false]);
        return back()->with('success', 'Comment rejected.');
    }

    public function deleteComment(BlogComment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }
}
