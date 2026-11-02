@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('crumb', 'Blog Posts')

@section('content')
<div class="adm-head">
  <div>
    <h1>Blog Posts</h1>
    <p>Shown on the Blog page and the home page, newest first</p>
  </div>
  <div class="adm-head__actions"><a class="adm-btn" href="{{ route('admin.blogs.create') }}"><i class="fa-solid fa-plus"></i> New Post</a></div>
</div>

<section class="adm-card">
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Post</th><th>Tag</th><th>Date</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($posts as $post)
          <tr>
            <td><div class="adm-cell"><img class="adm-thumb" style="width:72px; height:48px" src="{{ asset($post->image) }}" alt=""><a href="{{ route('admin.blogs.edit', $post) }}">{{ $post->title }}</a></div></td>
            <td>{{ $post->tag }}</td>
            <td>{{ $post->published_on->format('d M Y') }}</td>
            <td><span class="adm-badge adm-badge--{{ $post->is_published ? 'active' : 'closed' }}">{{ $post->is_published ? 'Published' : 'Draft' }}</span></td>
            <td>
              <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost adm-btn--sm" href="{{ url('blog-details?post='.$post->slug) }}" target="_blank" rel="noopener" aria-label="View"><i class="fa-solid fa-eye"></i></a>
                <a class="adm-btn adm-btn--ghost adm-btn--sm" href="{{ route('admin.blogs.edit', $post) }}">Edit</a>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="adm-empty">No posts yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>
@endsection
