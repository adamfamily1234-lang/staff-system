<!DOCTYPE html>
<html lang="ms">
<head><meta charset="UTF-8"><title>Tambah Sumbangan Profesional</title></head>
<body>
<div style="max-width:900px;margin:0 auto;padding:24px;">
    <h1>Tambah Sumbangan / Penglibatan Profesional</h1>
    <p><strong>Staf:</strong> {{ $staff->display_name }}</p>
    <form action="{{ route('staff.professional-contributions.store', $staff) }}" method="POST">
        @csrf
        @include('staff.professional-contributions._form')
        <br><br>
        <button type="submit">Simpan</button>
        <a href="{{ route('staff.show', $staff) }}">Batal</a>
    </form>
</div>
</body>
</html>
