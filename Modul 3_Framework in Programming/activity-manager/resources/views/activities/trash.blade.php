<h1>Trash Kegiatan</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@forelse ($activities as $activity)
    <div>
        <p>{{ $activity->code }} - {{ $activity->title }}</p>

        <form method="POST" action="{{ route('activities.restore', $activity->id) }}">
            @csrf
            @method('PATCH')
            <button type="submit">Restore</button>
        </form>
    </div>
@empty
    <p>Tidak ada kegiatan yang dihapus.</p>
@endforelse