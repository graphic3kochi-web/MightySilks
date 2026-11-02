@extends('layouts.admin')

@section('title', 'Careers')
@section('crumb', 'Careers')

@section('content')
<div class="adm-head">
  <div>
    <h1>Careers</h1>
    <p>Open roles on the Careers page</p>
  </div>
  <div class="adm-head__actions">
    <a class="adm-btn adm-btn--ghost" href="{{ route('admin.applications.index') }}"><i class="fa-solid fa-file-lines"></i> Applications</a>
    <a class="adm-btn" href="{{ route('admin.careers.create') }}"><i class="fa-solid fa-plus"></i> Add Role</a>
  </div>
</div>

<section class="adm-card">
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Role</th><th>Department</th><th>Location</th><th class="num">Applications</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($openings as $job)
          <tr>
            <td><a href="{{ route('admin.careers.edit', $job) }}">{{ $job->title }}</a><br><span class="muted">{{ $job->type }} · {{ $job->experience }}</span></td>
            <td>{{ $job->department }}</td>
            <td>{{ $job->location }}</td>
            <td class="num"><a href="{{ route('admin.applications.index', ['job' => $job->id]) }}">{{ $job->applications_count }}</a></td>
            <td><span class="adm-badge adm-badge--{{ $job->is_open ? 'active' : 'closed' }}">{{ $job->is_open ? 'Open' : 'Closed' }}</span></td>
            <td>
              <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost adm-btn--sm" href="{{ url('career-details.html?job='.$job->slug) }}" target="_blank" rel="noopener" aria-label="View"><i class="fa-solid fa-eye"></i></a>
                <a class="adm-btn adm-btn--ghost adm-btn--sm" href="{{ route('admin.careers.edit', $job) }}">Edit</a>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="adm-empty">No roles yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <p class="muted" style="margin-top:14px">Benefits shown on every role (unless it lists its own) are edited in <a href="{{ route('admin.settings.edit') }}">Settings</a>.</p>
</section>
@endsection
