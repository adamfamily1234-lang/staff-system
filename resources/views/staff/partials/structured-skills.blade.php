@php
    $levelLabels = [
        1 => 'Tahap 1 - Asas',
        2 => 'Tahap 2 - Berdikari',
        3 => 'Tahap 3 - Pakar / Rujukan',
    ];

    /*
     * Profile staff biasa hanya paparkan staff_visible.
     * Admin-only tidak dipaparkan di sini.
     *
     * Security query/policy sebenar akan diperkukuh
     * semasa module Role / Permission.
     */
    $visibleStructuredSkills = $staff->structuredSkills
        ->where('visibility_scope', 'staff_visible')
        ->sortBy(function ($item) {
            return sprintf(
                '%03d-%03d-%03d',
                $item->skill?->category?->cluster?->display_order ?? 999,
                $item->skill?->category?->display_order ?? 999,
                $item->skill?->display_order ?? 999
            );
        });
@endphp

<hr>

<h3>Structured Skills & Capability</h3>

<p>
    <a href="{{ route('staff.structured-skills.create', $staff) }}">
        + Tambah Structured Skill
    </a>
</p>

@if ($visibleStructuredSkills->count())
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Kluster</th>
                <th>Kategori</th>
                <th>Skill</th>
                <th>Tahap</th>
                <th>Pengalaman</th>
                <th>Kekerapan</th>
                <th>Konteks</th>
                <th>Bukti</th>
                <th>Status</th>
                <th>Tindakan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($visibleStructuredSkills as $item)
                <tr>
                    <td>
                        {{ $item->skill?->category?->cluster?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $item->skill?->category?->name ?? '-' }}
                    </td>

                    <td>
                        <strong>{{ $item->skill?->name ?? '-' }}</strong>
                    </td>

                    <td>
                        @if ($item->is_verified)
                            <strong>
                                {{ $levelLabels[$item->verified_level] ?? '-' }}
                            </strong>

                            @if (
                                $item->declared_level
                                && $item->declared_level !== $item->verified_level
                            )
                                <br>
                                <small>
                                    Self-claim:
                                    {{ $levelLabels[$item->declared_level] ?? '-' }}
                                </small>
                            @endif
                        @else
                            {{ $levelLabels[$item->declared_level] ?? '-' }}
                        @endif
                    </td>

                    <td>
                        @if ($item->years_experience !== null)
                            {{ $item->years_experience }} tahun
                        @elseif ($item->start_year)
                            Sejak {{ $item->start_year }}
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        {{ $item->frequency ?? '-' }}
                    </td>

                    <td>
                        {{ $item->context ?? '-' }}
                    </td>

                    <td>
                        @if ($item->evidence_type)
                            <strong>{{ $item->evidence_type }}</strong>
                            @if ($item->evidence_description)
                                <br>{{ $item->evidence_description }}
                            @endif
                        @else
                            {{ $item->evidence_description ?? '-' }}
                        @endif
                    </td>

                    <td>
                        @if ($item->is_verified)
                            <strong>Verified</strong>
                        @elseif ($item->verification_status === 'pending_verification')
                            Menunggu Pengesahan
                        @elseif ($item->verification_status === 'rejected')
                            Tidak Disahkan
                        @else
                            Self-Declared
                        @endif
                    </td>

                    <td>
                        @if (
                            $item->record_source === 'self_declared'
                            && $item->visibility_scope === 'staff_visible'
                        )
                            <a href="{{ route('staff.structured-skills.edit', [$staff, $item]) }}">
                                Edit
                            </a>

                            <form
                                action="{{ route('staff.structured-skills.destroy', [$staff, $item]) }}"
                                method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('Padam structured skill ini?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit">
                                    Padam
                                </button>
                            </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Tiada structured skill staff-visible direkodkan.</p>
@endif
