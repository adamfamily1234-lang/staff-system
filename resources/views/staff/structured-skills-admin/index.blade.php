<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Structured Skills</title>
</head>
<body>

<div style="max-width:1200px; margin:0 auto; padding:24px;">
    <h1>Admin / Penyelia — Structured Skills</h1>

    <p><strong>Staf:</strong> {{ $staff->display_name }}</p>

    @if (session('success'))
        <div style="margin:12px 0; color:green;">
            {{ session('success') }}
        </div>
    @endif

    <p>
        <a href="{{ route('staff.structured-skills-admin.create', $staff) }}">
            + Tambah Verified Skill
        </a>

        <a href="{{ route('staff.show', $staff) }}" style="margin-left:16px;">
            Kembali ke Profil
        </a>
    </p>

    @php
        $levelLabels = [
            1 => 'Tahap 1 - Asas',
            2 => 'Tahap 2 - Berdikari',
            3 => 'Tahap 3 - Pakar / Rujukan',
        ];
    @endphp

    @if ($staff->structuredSkills->count())
        <table border="1" cellpadding="8" cellspacing="0" style="width:100%;">
            <thead>
                <tr>
                    <th>Skill</th>
                    <th>Sumber</th>
                    <th>Visibility</th>
                    <th>Self-Claim</th>
                    <th>Verified</th>
                    <th>Status</th>
                    <th>Verifier</th>
                    <th>Tindakan</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($staff->structuredSkills as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->skill?->name ?? '-' }}</strong><br>
                            <small>
                                {{ $item->skill?->category?->cluster?->name ?? '-' }}
                                →
                                {{ $item->skill?->category?->name ?? '-' }}
                            </small>
                        </td>

                        <td>{{ $item->record_source }}</td>

                        <td>
                            @if ($item->visibility_scope === 'admin_only')
                                <strong>Admin Only</strong>
                            @else
                                Staff Visible
                            @endif
                        </td>

                        <td>
                            {{ $item->declared_level
                                ? ($levelLabels[$item->declared_level] ?? '-')
                                : '-' }}
                        </td>

                        <td>
                            {{ $item->verified_level
                                ? ($levelLabels[$item->verified_level] ?? '-')
                                : '-' }}
                        </td>

                        <td>{{ $item->verification_status }}</td>

                        <td>
                            {{ $item->verifier?->name ?? '-' }}
                            @if ($item->verified_at)
                                <br>
                                <small>{{ $item->verified_at->format('d/m/Y H:i') }}</small>
                            @endif
                        </td>

                        <td>
                            @if ($item->record_source === 'self_declared')
                                <a href="{{ route('staff.structured-skills-admin.verify-form', [$staff, $item]) }}">
                                    Verify / Review
                                </a>
                            @else
                                <a href="{{ route('staff.structured-skills-admin.edit', [$staff, $item]) }}">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('staff.structured-skills-admin.destroy', [$staff, $item]) }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Padam admin-added skill ini?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Padam</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tiada structured skill.</p>
    @endif
</div>

</body>
</html>
