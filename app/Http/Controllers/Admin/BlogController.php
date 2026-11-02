<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function index()
    {
        return view('admin.blogs.index', ['posts' => Blog::orderByDesc('published_on')->get()]);
    }

    public function create()
    {
        return view('admin.blogs.form', ['post' => new Blog(['published_on' => now(), 'read_time' => '5 min read', 'is_published' => true, 'body' => []])]);
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.form', ['post' => $blog]);
    }

    public function store(Request $request)
    {
        $post = $this->save($request, new Blog);

        return redirect()->route('admin.blogs.edit', $post)->with('status', 'Post published.');
    }

    public function update(Request $request, Blog $blog)
    {
        $this->save($request, $blog);

        return back()->with('status', 'Post saved.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('status', 'Post deleted.');
    }

    private function save(Request $request, Blog $post): Blog
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'regex:/^[a-z0-9-]+$/', 'max:255', Rule::unique('blogs', 'slug')->ignore($post->id)],
            'tag' => 'required|string|max:80',
            'category' => 'required|array|min:1',
            'category.*' => Rule::in(array_keys(Blog::CATEGORIES)),
            'published_on' => 'required|date',
            'read_time' => 'required|string|max:30',
            'excerpt' => 'required|string|max:500',
            'body' => 'required|string',
            'alt' => 'nullable|string|max:255',
            'image' => [$post->exists ? 'nullable' : 'required', 'image', 'max:4096'],
            'shop_label' => 'nullable|string|max:80',
            'shop_href' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $post->fill([
            ...collect($data)->except(['image', 'category', 'body'])->all(),
            'slug' => ($data['slug'] ?? null) ?: ($post->slug ?? $this->uniqueSlug(Str::slug($data['title']))),
            'category' => implode(' ', $data['category']),
            'body' => Blog::parseBody($data['body']),
        ]);
        if ($request->hasFile('image')) {
            $post->image = 'storage/'.$request->file('image')->store('blogs', 'public');
        }
        $post->save();

        return $post;
    }

    /** "silk-care", or "silk-care-2"… when a post already has it. */
    private function uniqueSlug(string $slug): string
    {
        for ($i = 2, $try = $slug; Blog::where('slug', $try)->exists(); $i++) {
            $try = "$slug-$i";
        }

        return $try;
    }
}
