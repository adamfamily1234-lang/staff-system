<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kursus</title>
</head>
<body>
<h1>Edit Rekod Kursus</h1>
<p><a href="{{ route('staff.show', $staff) }}">← Kembali ke Profil Staf</a></p>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('staff.courses.update', [$staff, $course]) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Jenis Bidang</label><br>
    <select name="course_field_type_id">
        <option value="">-- Pilih Jenis Bidang --</option>
        @foreach ($courseFieldTypes as $item)
            <option value="{{ $item->id }}"
                {{ (string) old('course_field_type_id', $course->course_field_type_id) === (string) $item->id ? 'selected' : '' }}>
                {{ $item->name }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Kategori Utama Kursus</label><br>
    <select name="course_main_category_id">
        <option value="">-- Pilih Kategori Utama --</option>
        @foreach ($courseMainCategories as $item)
            <option value="{{ $item->id }}"
                {{ (string) old('course_main_category_id', $course->course_main_category_id) === (string) $item->id ? 'selected' : '' }}>
                {{ $item->name }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Sistem / Sub-Kategori</label><br>
    <select name="course_sub_category_id">
        <option value="">-- Pilih Sistem / Sub-Kategori --</option>
        @foreach ($courseSubCategories as $item)
            <option value="{{ $item->id }}"
                {{ (string) old('course_sub_category_id', $course->course_sub_category_id) === (string) $item->id ? 'selected' : '' }}>
                {{ $item->name }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Nama Kursus</label><br>
    <input type="text" name="course_name"
           value="{{ old('course_name', $course->course_name) }}" required>
    <br><br>

    <label>Penganjur</label><br>
    <input type="text" name="organizer"
           value="{{ old('organizer', $course->organizer) }}">
    <br><br>

    <label>Tarikh Mula</label><br>
    <input type="date" name="start_date"
           value="{{ old('start_date', $course->start_date?->format('Y-m-d') ?? $course->start_date) }}">
    <br><br>

    <label>Tarikh Tamat</label><br>
    <input type="date" name="end_date"
           value="{{ old('end_date', $course->end_date?->format('Y-m-d') ?? $course->end_date) }}">
    <br><br>

    <label>Tempat</label><br>
    <input type="text" name="venue"
           value="{{ old('venue', $course->venue) }}">
    <br><br>

    <label>Catatan</label><br>
    <textarea name="notes" rows="4" cols="50">{{ old('notes', $course->notes) }}</textarea>
    <br><br>

    <button type="submit">Simpan Perubahan</button>
</form>
</body>
</html>
