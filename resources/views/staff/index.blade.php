<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senarai Staf</title>
</head>
<body>

<h1>Senarai Staf</h1>

<p>
    <a href="{{ route('staff.create') }}">+ Tambah Staf</a>
    &nbsp; | &nbsp;
    <a href="{{ route('staff.seniority') }}">Lihat Kekananan Staf</a>
</p>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<hr>

<h3>Carian & Penapis</h3>

<form action="{{ route('staff.index') }}" method="GET">

    <div>
        <label for="search">Cari Nama / No. KP / No. Staf</label><br>
        <input
            type="text"
            name="search"
            id="search"
            value="{{ request('search') }}"
            placeholder="Contoh: Ahmad / 900101 / TEST001"
            style="min-width: 300px;"
        >
    </div>

    <br>

    <div>
        <label for="department_id">Bahagian Semasa</label><br>
        <select name="department_id" id="department_id">
            <option value="">-- Semua Bahagian --</option>
            @foreach ($departments as $department)
                <option
                    value="{{ $department->id }}"
                    {{ (string) request('department_id') === (string) $department->id ? 'selected' : '' }}
                >
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="unit_id">Unit Semasa</label><br>
        <select name="unit_id" id="unit_id">
            <option value="">-- Semua Unit --</option>
            @foreach ($units as $unit)
                <option
                    value="{{ $unit->id }}"
                    {{ (string) request('unit_id') === (string) $unit->id ? 'selected' : '' }}
                >
                    {{ $unit->name }}
                    @if ($unit->department)
                        - {{ $unit->department->name }}
                    @endif
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="grade_master_id">Gred Semasa</label><br>
        <select name="grade_master_id" id="grade_master_id">
            <option value="">-- Semua Gred --</option>
            @foreach ($gradeMasters as $grade)
                <option
                    value="{{ $grade->id }}"
                    {{ (string) request('grade_master_id') === (string) $grade->id ? 'selected' : '' }}
                >
                    {{ $grade->grade_code }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="service_status">Status Perkhidmatan</label><br>
        <select name="service_status" id="service_status">
            <option value="">-- Semua Status --</option>
            @foreach ($serviceStatuses as $status)
                <option
                    value="{{ $status }}"
                    {{ request('service_status') === $status ? 'selected' : '' }}
                >
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <button type="submit">Cari / Tapis</button>
    <a href="{{ route('staff.index') }}">Reset</a>

</form>

<hr>

<p>
    Jumlah rekod dijumpai:
    <strong>{{ $staff->total() }}</strong>
</p>

@if ($staff->count())

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Staf</th>
                <th>Nama</th>
                <th>Jawatan Semasa</th>
                <th>Gred Semasa</th>
                <th>Bahagian Semasa</th>
                <th>Unit Semasa</th>
                <th>Status Perkhidmatan</th>
                <th>Tindakan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($staff as $person)

                @php
                    $service = $person->serviceRecords->first();

                    $currentPlacement = $person->placements
                        ->whereNull('end_date')
                        ->sortByDesc('start_date')
                        ->first();
                @endphp

                <tr>
                    <td>{{ $staff->firstItem() + $loop->index }}</td>

                    <td>{{ $service?->staff_no ?? '-' }}</td>

                    <td>{{ $person->name }}</td>

                    <td>
                        {{
                            $currentPlacement?->position?->name
                            ?? $service?->position
                            ?? '-'
                        }}
                    </td>

                    <td>
                        {{
                            $currentPlacement?->grade?->grade_code
                            ?? $service?->grade
                            ?? '-'
                        }}
                    </td>

                    <td>
                        {{
                            $currentPlacement?->department?->name
                            ?? $service?->department?->name
                            ?? '-'
                        }}
                    </td>

                    <td>
                        {{
                            $currentPlacement?->unit?->name
                            ?? $service?->unit?->name
                            ?? '-'
                        }}
                    </td>

                    <td>{{ $service?->service_status ?? '-' }}</td>

                    <td>
                        <a href="{{ route('staff.show', $person) }}">Lihat</a>
                        &nbsp; | &nbsp;
                        <a href="{{ route('staff.edit', $person) }}">Edit</a>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

    <br>

    <div>
        {{ $staff->links() }}
    </div>

@else

    <p>Tiada rekod staf yang sepadan dengan carian / penapis.</p>

@endif


@auth
    <div>
        Log masuk sebagai: {{ auth()->user()->name }}

        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit">Log Keluar</button>
        </form>
    </div>
@endauth

</body>
</html>
