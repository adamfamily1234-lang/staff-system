<section style="margin-top:28px;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:12px;">
        <h2 style="margin:0;">Pengiktirafan Profesional / Sijil Ikhtisas</h2>

        <a
            href="{{ route('staff.professional-recognitions.create', $staff) }}"
            style="text-decoration:none;"
        >
            + Tambah Pengiktirafan
        </a>
    </div>

    @php
        $professionalRecognitions = $staff->professionalRecognitions()
            ->with('master')
            ->get()
            ->sortBy(fn ($item) => $item->master?->display_order ?? 9999);
    @endphp

    @if ($professionalRecognitions->isEmpty())
        <div style="padding:14px; background:#f8fafc; border:1px solid #e5e7eb;">
            Belum ada rekod pengiktirafan profesional.
        </div>
    @else
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="text-align:left; border:1px solid #ddd; padding:8px;">Badan</th>
                        <th style="text-align:left; border:1px solid #ddd; padding:8px;">Tahap Profesional</th>
                        <th style="text-align:left; border:1px solid #ddd; padding:8px;">Gelaran</th>
                        <th style="text-align:left; border:1px solid #ddd; padding:8px;">Reg. No.</th>
                        <th style="text-align:left; border:1px solid #ddd; padding:8px;">Tarikh</th>
                        <th style="text-align:left; border:1px solid #ddd; padding:8px;">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($professionalRecognitions as $recognition)
                        @php
                            $master = $recognition->master;

                            $prefix = $recognition->selected_prefix_title
                                ?: (
                                    $master &&
                                    $master->prefix_title &&
                                    !str_contains($master->prefix_title, ' / ')
                                        ? $master->prefix_title
                                        : null
                                );

                            $suffix = $recognition->selected_suffix_title
                                ?: (
                                    $master &&
                                    $master->suffix_title &&
                                    !str_contains($master->suffix_title, ' / ')
                                        ? $master->suffix_title
                                        : null
                                );
                        @endphp

                        <tr>
                            <td style="border:1px solid #ddd; padding:8px;">
                                {{ $master?->issuer ?? '-' }}
                                <div style="font-size:12px; color:#666;">
                                    {{ $master?->registration_scope ?? '-' }}
                                </div>
                            </td>

                            <td style="border:1px solid #ddd; padding:8px;">
                                {{ $master?->professional_level ?? '-' }}
                            </td>

                            <td style="border:1px solid #ddd; padding:8px;">
                                {{ $prefix ?: '-' }}
                                @if ($suffix)
                                    / {{ $suffix }}
                                @endif
                            </td>

                            <td style="border:1px solid #ddd; padding:8px;">
                                {{ $recognition->registration_no ?: '-' }}
                            </td>

                            <td style="border:1px solid #ddd; padding:8px;">
                                {{ $recognition->registered_awarded_date?->format('d/m/Y') ?? '-' }}
                            </td>

                            <td style="border:1px solid #ddd; padding:8px; white-space:nowrap;">
                                <a href="{{ route('staff.professional-recognitions.edit', [$staff, $recognition]) }}">
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('staff.professional-recognitions.destroy', [$staff, $recognition]) }}"
                                    style="display:inline;"
                                    onsubmit="return confirm('Padam rekod pengiktirafan profesional ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" style="margin-left:8px;">
                                        Padam
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
