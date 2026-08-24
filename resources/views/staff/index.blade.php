<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Senarai Staf</title>
</head>

<body>

    <h1>Senarai Staf</h1>

    <a href="#">
        + Tambah Staf
    </a>

    <hr>

    @if ($staff->count())

        <table border="1" cellpadding="10" cellspacing="0">

            <thead>
                <tr>
                    <th>No. Staf</th>
                    <th>Nama</th>
                    <th>Jawatan</th>
                    <th>Gred</th>
                    <th>Bahagian</th>
                    <th>Unit</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($staff as $person)

                    @php
                        $service = $person->serviceRecords->first();
                    @endphp

                    <tr>

                        <td>
                            {{ $service?->staff_no ?? '-' }}
                        </td>

                        <td>
                            {{ $person->name }}
                        </td>

                        <td>
                            {{ $service?->position ?? '-' }}
                        </td>

                        <td>
                            {{ $service?->grade ?? '-' }}
                        </td>

                        <td>
                            {{ $service?->department?->name ?? '-' }}
                        </td>

                        <td>
                            {{ $service?->unit?->name ?? '-' }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        <div>
            {{ $staff->links() }}
        </div>

    @else

        <p>Tiada rekod staf.</p>

    @endif

</body>
</html>