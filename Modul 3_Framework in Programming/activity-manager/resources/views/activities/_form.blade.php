<label for="code">Kode</label>

<input
    id="code"
    name="code"
    value="{{ old('code', $activity->code ?? '') }}"
>

@error('code')
    <p class="error">{{ $message }}</p>
@enderror

<label for="title">Judul</label>
<input
    id="title"
    name="title"
    value="{{ old('title', $activity->title ?? '') }}"
>
@error('title')
    <p class="error">{{ $message }}</p>
@enderror

<label for="description">Deskripsi</label>
<textarea id="description" name="description">{{ old('description', $activity->description ?? '') }}</textarea>
@error('description')
    <p class="error">{{ $message }}</p>
@enderror

<label for="activity_date">Tanggal</label>
<input
    type="date"
    id="activity_date"
    name="activity_date"
    value="{{ old('activity_date', isset($activity) ? $activity->activity_date->format('Y-m-d') : '') }}"
>
@error('activity_date')
    <p class="error">{{ $message }}</p>
@enderror

<label for="category_id">Kategori</label>

<select id="category_id" name="category_id">
    <option value="">-- Pilih Kategori --</option>

    @foreach ($categories as $category)
        <option
            value="{{ $category->id }}"
            @selected(old('category_id', $activity->category_id ?? '') == $category->id)
        >
            {{ $category->name }}
        </option>
    @endforeach
</select>

@error('category_id')
    <p class="error">{{ $message }}</p>
@enderror



<label for="start_at">Waktu Mulai</label>
<input
    type="datetime-local"
    id="start_at"
    name="start_at"
    value="{{ old('start_at', isset($activity) && $activity->start_at ? $activity->start_at->format('Y-m-d\TH:i') : '') }}"
>
@error('start_at')
    <p class="error">{{ $message }}</p>
@enderror

<label for="end_at">Waktu Selesai</label>
<input
    type="datetime-local"
    id="end_at"
    name="end_at"
    value="{{ old('end_at', isset($activity) && $activity->end_at ? $activity->end_at->format('Y-m-d\TH:i') : '') }}"
>
@error('end_at')
    <p class="error">{{ $message }}</p>
@enderror

<label for="capacity">Kapasitas</label>
<input
    type="number"
    id="capacity"
    name="capacity"
    value="{{ old('capacity', $activity->capacity ?? '') }}"
>
@error('capacity')
    <p class="error">{{ $message }}</p>
@enderror