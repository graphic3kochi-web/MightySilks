@extends('layouts.admin')

@section('title', $application->name)
@section('crumb', 'Application')

@section('content')
<div class="adm-head">
  <div>
    <h1>{{ $application->name }}</h1>
    <p>{{ $application->position }} · received {{ $application->created_at->format('d M Y, H:i') }}</p>
  </div>
  <div class="adm-head__actions">
    <a class="adm-btn" href="{{ route('admin.applications.cv', $application) }}"><i class="fa-solid fa-download"></i> Download CV</a>
  </div>
</div>

<div class="adm-detail">
  <section class="adm-card">
    <div class="adm-card__head"><span class="adm-card__icon"><i class="fa-solid fa-user"></i></span><h2 class="adm-card__title">Applicant</h2></div>
    <dl class="adm-dl">
      <dt>Email</dt><dd><a href="mailto:{{ $application->email }}">{{ $application->email }}</a></dd>
      <dt>Phone</dt><dd>{{ $application->phone }}</dd>
      <dt>Role</dt><dd>{{ $application->position }}</dd>
      <dt>CV</dt><dd>{{ $application->cv_name }}</dd>
    </dl>
    @if ($application->message)
      <p class="dash-sublabel">Message</p>
      <p class="adm-prose">{{ $application->message }}</p>
    @endif
  </section>
  <form class="adm-card" method="post" action="{{ route('admin.applications.update', $application) }}">
    @csrf @method('put')
    <div class="adm-grid" style="grid-template-columns:1fr">
      <x-admin.field name="status" label="Status" :options="\App\Models\JobApplication::STATUSES" :value="$application->status" />
    </div>
    <div class="adm-form__bar"><button class="adm-btn" type="submit">Save</button></div>
  </form>
</div>
@endsection
