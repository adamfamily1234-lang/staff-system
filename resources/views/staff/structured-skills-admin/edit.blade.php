<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Edit Verified Skill</title>
</head>
<body>
<div style="max-width:1000px; margin:0 auto; padding:24px;">
    <h1>Edit Admin / Supervisor Added Skill</h1>
    <p><strong>Staf:</strong> {{ $staff->display_name }}</p>

    <form method="POST"
          action="{{ route('staff.structured-skills-admin.update', [$staff, $structuredSkill]) }}">
        @csrf
        @method('PUT')

        @include(
            'staff.structured-skills-admin._form',
            ['structuredSkill' => $structuredSkill]
        )

        <br>
        <button type="submit">Simpan Perubahan</button>
        <a href="{{ route('staff.structured-skills-admin.index', $staff) }}" style="margin-left:10px;">
            Batal
        </a>
    </form>
</div>
</body>
</html>
