<hr>
<h3>Sumbangan / Penglibatan Profesional</h3>

<p>
    <a href="{{ route('staff.professional-contributions.create', $staff) }}">
        + Tambah Sumbangan / Penglibatan
    </a>
</p>

@if ($staff->professionalContributions->count())
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
    <tr>
        <th>Jenis</th><th>Aktiviti / Sumbangan</th><th>Peranan</th>
        <th>Organisasi</th><th>Peringkat</th><th>Tempoh</th>
        <th>No. Rujukan</th><th>Catatan</th><th>Tindakan</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($staff->professionalContributions->sortByDesc('start_date') as $item)
    <tr>
        <td>{{ $item->activity_type ?? '-' }}</td>
        <td>{{ $item->activity_name }}</td>
        <td>{{ $item->role ?? '-' }}</td>
        <td>{{ $item->organization ?? '-' }}</td>
        <td>{{ $item->level ?? '-' }}</td>
        <td>
            {{ $item->start_date?->format('d/m/Y') ?? '-' }}
            @if ($item->end_date)
                hingga {{ $item->end_date->format('d/m/Y') }}
            @elseif ($item->start_date)
                hingga Semasa
            @endif
        </td>
        <td>{{ $item->reference_no ?? '-' }}</td>
        <td>{{ $item->notes ?? '-' }}</td>
        <td>
            <a href="{{ route('staff.professional-contributions.edit', [$staff, $item]) }}">Edit</a>
            <form action="{{ route('staff.professional-contributions.destroy', [$staff, $item]) }}"
                  method="POST" style="display:inline;"
                  onsubmit="return confirm('Padam rekod ini?');">
                @csrf
                @method('DELETE')
                <button type="submit">Padam</button>
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
<p>Tiada rekod sumbangan / penglibatan profesional.</p>
@endif
