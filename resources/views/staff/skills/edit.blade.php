<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kemahiran</title>
</head>
<body>
<h1>Edit Rekod Kemahiran</h1>
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

<form action="{{ route('staff.skills.update', [$staff, $skill]) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Kemahiran</label><br>
    <input type="text" name="skill"
           value="{{ old('skill', $skill->skill) }}" required>
    <br><br>

    <label>Tahap</label><br>
    <select name="level" required>
        @foreach (['Asas','Sederhana','Mahir','Pakar'] as $level)
            <option value="{{ $level }}"
                {{ old('level', $skill->level) === $level ? 'selected' : '' }}>
                {{ $level }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Keterangan</label><br>
    <textarea name="description" rows="4" cols="50">{{ old('description', $skill->description) }}</textarea>
    <br><br>

    <button type="submit">Simpan Perubahan</button>
</form>
</body>
</html>
