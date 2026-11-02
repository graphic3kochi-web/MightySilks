@extends('layouts.admin')

@section('title', $post->exists ? $post->title : 'New Post')
@section('crumb', $post->exists ? 'Edit Post' : 'New Post')

@section('content')
@php $chosen = old('category', explode(' ', (string) $post->category)); @endphp
<div class="adm-head">
  <h1>{{ $post->exists ? 'Edit Post' : 'New Post' }}</h1>
  @if ($post->exists)
    <div class="adm-head__actions">
      <a class="adm-btn adm-btn--ghost" href="{{ url('blog-details?post='.$post->slug) }}" target="_blank" rel="noopener"><i class="fa-solid fa-eye"></i> View</a>
      <form method="post" action="{{ route('admin.blogs.destroy', $post) }}" data-confirm="Delete this post?">@csrf @method('delete')<button class="adm-btn adm-btn--danger" type="submit"><i class="fa-solid fa-trash"></i> Delete</button></form>
    </div>
  @endif
</div>

<form class="adm-form" method="post" enctype="multipart/form-data" action="{{ $post->exists ? route('admin.blogs.update', $post) : route('admin.blogs.store') }}">
  @csrf
  @if ($post->exists) @method('put') @endif
  <div>
    <section class="adm-card">
      <div class="adm-grid">
        <x-admin.field name="title" label="Title" :value="$post->title" required wide />
        <x-admin.field name="excerpt" label="Excerpt" type="textarea" rows="2" :value="$post->excerpt" required help="The summary on the blog page cards." wide />
        <x-admin.field name="body" label="Article" type="textarea" rows="18" :value="$post->exists ? $post->bodyText() : ''" required wide
          help="Separate blocks with a blank line. Start a line with “## ” for a heading, “- ” for list items, “> ” for a pull quote; anything else is a paragraph." />
      </div>
    </section>
  </div>
  <div>
    <section class="adm-card">
      <div class="adm-grid" style="grid-template-columns:1fr">
        <x-admin.check name="is_published" label="Published" :checked="$post->is_published" />
        <x-admin.field name="published_on" label="Date" type="date" :value="$post->published_on?->toDateString()" required />
        <x-admin.field name="tag" label="Tag" :value="$post->tag" required help="The label on the post, e.g. Bridal Kanchipuram Saree." />
        <div class="adm-field">
          <span class="adm-label">Categories (blog filters)</span>
          @foreach (\App\Models\Blog::CATEGORIES as $key => $label)
            <label class="adm-check"><input type="checkbox" name="category[]" value="{{ $key }}" @checked(in_array($key, $chosen))> {{ $label }}</label>
          @endforeach
          @error('category')<span class="adm-error">{{ $message }}</span>@enderror
        </div>
        <x-admin.field name="read_time" label="Read time" :value="$post->read_time" required />
        <x-admin.field name="slug" label="Address" :value="$post->slug" help="blog-details?post=address. Empty: made from the title." />
      </div>
    </section>
    <section class="adm-card">
      <div class="adm-grid" style="grid-template-columns:1fr">
        @if ($post->image)<img src="{{ asset($post->image) }}" alt="" style="border-radius:10px">@endif
        <x-admin.field name="image" label="{{ $post->image ? 'Replace cover photo' : 'Cover photo' }}" type="file" accept="image/*" />
        <x-admin.field name="alt" label="Cover description (alt text)" :value="$post->alt" />
        <x-admin.field name="shop_label" label="“Shop the look” button" :value="$post->shop_label" />
        <x-admin.field name="shop_href" label="…links to" :value="$post->shop_href" help="A page, e.g. /bridal" />
      </div>
    </section>
    <div class="adm-form__bar">
      <a class="adm-btn adm-btn--ghost" href="{{ route('admin.blogs.index') }}">Cancel</a>
      <button class="adm-btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save Post</button>
    </div>
  </div>
</form>
@endsection
