<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Tambah Verified Skill</title>
</head>
<body>
<div style="max-width:1000px; margin:0 auto; padding:24px;">
    <h1>Tambah Verified Skill — Admin / Penyelia</h1>
    <p><strong>Staf:</strong> {{ $staff->display_name }}</p>

    <form method="POST"
          action="{{ route('staff.structured-skills-admin.store', $staff) }}">
        @csrf

        @include('staff.structured-skills-admin._form')

        <br>
        <button type="submit">Simpan Sebagai Verified</button>
        <a href="{{ route('staff.structured-skills-admin.index', $staff) }}" style="margin-left:10px;">
            Batal
        </a>
    </form>
</div>
</body>
</html>
