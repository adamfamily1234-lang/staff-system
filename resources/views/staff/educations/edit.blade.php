<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pendidikan</title>
</head>
<body>
<h1>Edit Rekod Pendidikan</h1>
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

<form action="{{ route('staff.educations.update', [$staff, $education]) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Peringkat</label><br>
    <select name="level" required>
        @foreach ([
            'Sijil',
            'Diploma',
            'Ijazah Sarjana Muda',
            'Ijazah Sarjana',
            'Ijazah Doktor Falsafah',
            'Pascadoktorat',
            'Profesor Madya',
            'Profesor',
            'Profesor Ulung'
        ] as $level)
            <option value="{{ $level }}"
                {{ old('level', $education->level) === $level ? 'selected' : '' }}>
                {{ $level }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Nama / Kelayakan</label><br>
    <input type="text" name="qualification"
           value="{{ old('qualification', $education->qualification) }}" required>
    <br><br>

    <label>Institusi</label><br>
    <input type="text" name="institution"
           value="{{ old('institution', $education->institution) }}">
    <br><br>

    <label>Tahun</label><br>
    <input type="number" name="year" min="1900" max="2200"
           value="{{ old('year', $education->year) }}">
    <br><br>

    <button type="submit">Simpan Perubahan</button>
</form>
</body>
</html>
