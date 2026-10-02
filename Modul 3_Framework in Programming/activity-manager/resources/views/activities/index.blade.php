@extends('layouts.app')

@section('content')

<h1>Daftar Kegiatan</h1>

@foreach ($activities as $activity)
    <h3>
        <a href="{{ route('activities.show', $activity) }}">
            {{ $activity->title }}
        </a>
    </h3>

    <p>{{ $activity->activity_date->format('d M Y') }}</p>
    <p>Kategori: {{ $activity->category->name }}</p>
    <p>Status: {{ $activity->status }}</p>
@endforeach

<div style="font-size: 14px;">
    {{ $activities->links() }}
</div>

@endsection