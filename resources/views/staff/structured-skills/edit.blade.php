<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Structured Skill</title>
</head>
<body>

<div style="max-width:1000px; margin:0 auto; padding:24px;">
    <h1>Edit Self-Declared Structured Skill</h1>

    <p>
        <strong>Staf:</strong>
        {{ $staff->display_name }}
    </p>

    <form
        action="{{ route('staff.structured-skills.update', [$staff, $structuredSkill]) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        @include(
            'staff.structured-skills._form',
            ['structuredSkill' => $structuredSkill]
        )

        <br>

        <button type="submit">
            Simpan Perubahan
        </button>

        <a
            href="{{ route('staff.show', $staff) }}"
            style="margin-left:10px;"
        >
            Batal
        </a>
    </form>
</div>

</body>
</html>
