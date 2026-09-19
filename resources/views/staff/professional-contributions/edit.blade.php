<!DOCTYPE html>
<html lang="ms">
<head><meta charset="UTF-8"><title>Edit Sumbangan Profesional</title></head>
<body>
<div style="max-width:900px;margin:0 auto;padding:24px;">
    <h1>Edit Sumbangan / Penglibatan Profesional</h1>
    <p><strong>Staf:</strong> {{ $staff->display_name }}</p>
    <form action="{{ route('staff.professional-contributions.update', [$staff, $professionalContribution]) }}" method="POST">
        @csrf
        @method('PUT')
        @include('staff.professional-contributions._form', ['professionalContribution' => $professionalContribution])
        <br><br>
        <button type="submit">Simpan Perubahan</button>
        <a href="{{ route('staff.show', $staff) }}">Batal</a>
    </form>
</div>
</body>
</html>
