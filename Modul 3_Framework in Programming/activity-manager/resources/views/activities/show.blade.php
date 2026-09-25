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
    {{ $activity->category }}
</p>

<p>
    Status:
    {{ $activity->status }}
</p>

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