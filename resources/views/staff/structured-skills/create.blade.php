<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Structured Skill</title>
</head>
<body>

<div style="max-width:1000px; margin:0 auto; padding:24px;">
    <h1>Tambah Structured Skill</h1>

    <p>
        <strong>Staf:</strong>
        {{ $staff->display_name }}
    </p>

    <p style="max-width:750px;">
        Rekod ini ialah <strong>Self-Declared</strong>.
        Status Verified hanya boleh diberikan melalui flow Admin / Penyelia.
    </p>

    <form
        action="{{ route('staff.structured-skills.store', $staff) }}"
        method="POST"
    >
        @csrf

        @include('staff.structured-skills._form')

        <br>

        <button type="submit">
            Simpan Self-Declared Skill
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
