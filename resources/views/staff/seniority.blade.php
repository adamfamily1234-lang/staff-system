<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Senarai Kekananan Staf</title>
</head>

<body>

    <h1>Senarai Kekananan Staf</h1>

    <p>
        <a href="{{ route('staff.index') }}">
            ← Kembali ke Senarai Staf
        </a>
    </p>

    <p>
        Kekananan dikira berdasarkan
        <strong>Gred Hakiki sahaja</strong>.
        Rekod Memangku tidak diambil kira.
    </p>

    <table border="1" cellpadding="10" cellspacing="0">

        <thead>
            <tr>
                <th>Ranking</th>
                <th>Nama</th>
                <th>Gred Hakiki</th>
                <th>Tarikh Mula Hakiki</th>
                <th>Tempoh Dalam Gred</th>
                <th>Jawatan</th>
                <th>Bahagian</th>
                <th>Unit</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($seniorityList as $index => $person)

                @php
                    $placement = $person->seniority_placement;

                    $start = $person->seniority_start_date;

                    $end = $placement?->end_date ?? now();

                    $duration = $start
                        ? $start->diff($end)
                        : null;
                @endphp

                <tr>

                    <td>
                        @if ($person->seniority_rank > 0)
                            {{ $index + 1 }}
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('staff.show', $person) }}">
                            {{ $person->name }}
                        </a>
                    </td>

                    <td>
                        {{ $person->seniority_grade ?? '-' }}
                    </td>

                    <td>
                        {{ $person->seniority_start_date?->format('d/m/Y') ?? '-' }}
                    </td>

                    <td>
                        @if ($duration)

                            {{ $duration->y }} Tahun
                            {{ $duration->m }} Bulan
                            {{ $duration->d }} Hari

                        @else

                            -

                        @endif
                    </td>

                    <td>
                        {{ $placement?->position?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $placement?->department?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $placement?->unit?->name ?? '-' }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>