<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anugerah</title>
</head>
<body>
<h1>Edit Rekod Anugerah</h1>
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

<form action="{{ route('staff.awards.update', [$staff, $award]) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama Anugerah</label><br>
    <input type="text" name="award_name"
           value="{{ old('award_name', $award->award_name) }}" required>
    <br><br>

    <label>Pemberi / Organisasi</label><br>
    <input type="text" name="organization"
           value="{{ old('organization', $award->organization) }}">
    <br><br>

    <label>Tahun</label><br>
    <input type="number" name="year" min="1900" max="2200"
           value="{{ old('year', $award->year) }}">
    <br><br>

    <label>Peringkat</label><br>
    <select name="level">
        <option value="">-- Pilih Peringkat --</option>
        @foreach (['Jabatan','Negeri','Kebangsaan','Antarabangsa','Lain-lain'] as $level)
            <option value="{{ $level }}"
                {{ old('level', $award->level) === $level ? 'selected' : '' }}>
                {{ $level }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Catatan</label><br>
    <textarea name="notes" rows="4" cols="50">{{ old('notes', $award->notes) }}</textarea>
    <br><br>

    <button type="submit">Simpan Perubahan</button>
</form>
</body>
</html>
