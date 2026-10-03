@extends('layouts.app')
@section('content')

<h1>{{ $activity->title }}</h1>
<p>{{ $activity->description }}</p>

<p>
    Tanggal:
    {{ $activity->activity_date->format('d M Y') }}
</p>

<p>
    Kategori:
    {{ $activity->category->name }}
</p>

<p>
    Status:
    {{ $activity->status }}
</p>

@if ($activity->status === 'draft')
    <form method="POST" action="{{ route('activities.publish', $activity) }}">
        @csrf
        @method('PATCH')

        <button type="submit">Publish</button>
    </form>
@endif

@if ($activity->status === 'published')
    <form method="POST" action="{{ route('activities.complete', $activity) }}">
        @csrf
        @method('PATCH')

        <button type="submit">Complete</button>
    </form>
@endif

<a href="{{ route('activities.index') }}">Kembali ke daftar</a>

<a href="{{ route('activities.edit', $activity) }}">Edit</a>

<form
    method="POST"
    action="{{ route('activities.destroy', $activity) }}"
    onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')"
>
    @csrf
    @method('DELETE')

    <button type="submit">Hapus</button>
</form>
@endsection