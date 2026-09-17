<section style="margin-top:28px;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:12px;">
        <h2 style="margin:0;">Kurniaan / Gelaran Kehormat</h2>

        <a
            href="{{ route('staff.honorary-titles.create', $staff) }}"
            style="text-decoration:none;"
        >
            + Tambah Kurniaan
        </a>
    </div>

    @php
        $honoraryTitles = $staff->honoraryTitles()
            ->with('master')
            ->get()
            ->sortBy(fn ($item) => $item->master?->display_order ?? 9999);
    @endphp

    @if ($honoraryTitles->isEmpty())
        <div style="padding:14px; background:#f8fafc; border:1px solid #e5e7eb;">
            Belum ada rekod kurniaan / gelaran kehormat.
        </div>
    @else
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="text-align:left; border:1px solid #ddd; padding:8px;">Pengurnia</th>
                        <th style="text-align:left; border:1px solid #ddd; padding:8px;">Darjah / Anugerah</th>
                        <th style="text-align:left; border:1px solid #ddd; padding:8px;">Gelaran</th>
                        <th style="text-align:left; border:1px solid #ddd; padding:8px;">No. Watikah</th>
                        <th style="text-align:left; border:1px solid #ddd; padding:8px;">Tarikh</th>
                        <th style="text-align:left; border:1px solid #ddd; padding:8px;">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($honoraryTitles as $title)
                        @php
                            $master = $title->master;

                            $prefix = $title->selected_prefix_title
                                ?: (
                                    $master &&
                                    $master->prefix_title &&
                                    !str_contains($master->prefix_title, ' / ')
                                        ? $master->prefix_title
                                        : null
                                );

                            $suffix = $title->selected_suffix_title
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
                                    {{ $master?->scope_level ?? '-' }}
                                </div>
                            </td>

                            <td style="border:1px solid #ddd; padding:8px;">
                                {{ $master?->award_name ?? '-' }}
                            </td>

                            <td style="border:1px solid #ddd; padding:8px;">
                                {{ $prefix ?: '-' }}
                                @if ($suffix)
                                    / {{ $suffix }}
                                @endif
                            </td>

                            <td style="border:1px solid #ddd; padding:8px;">
                                {{ $title->warrant_serial_no ?: '-' }}
                            </td>

                            <td style="border:1px solid #ddd; padding:8px;">
                                {{ $title->registered_awarded_date?->format('d/m/Y') ?? '-' }}
                            </td>

                            <td style="border:1px solid #ddd; padding:8px; white-space:nowrap;">
                                <a href="{{ route('staff.honorary-titles.edit', [$staff, $title]) }}">
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('staff.honorary-titles.destroy', [$staff, $title]) }}"
                                    style="display:inline;"
                                    onsubmit="return confirm('Padam rekod kurniaan / gelaran kehormat ini?')"
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
