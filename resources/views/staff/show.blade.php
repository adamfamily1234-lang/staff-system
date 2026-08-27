<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil Staf - {{ $staff->name }}</title>
</head>

<body>

    <h1>Profil Staf</h1>

    <p>
        <a href="{{ route('staff.index') }}">
            ← Kembali ke Senarai Staf
        </a>
    </p>

    <hr>

    {{-- Maklumat Peribadi --}}
    <h2>1. Maklumat Peribadi</h2>

    <table border="1" cellpadding="8" cellspacing="0">

        <tr>
            <th>Nama</th>
            <td>{{ $staff->name }}</td>
        </tr>

        <tr>
            <th>No. KP</th>
            <td>{{ $staff->ic_no }}</td>
        </tr>

        <tr>
            <th>Gelaran (di pangkal nama)</th>
            <td>{{ $staff->prefix_title ?? '-' }}</td>
        </tr>

        <tr>
            <th>Gelaran (di hujung nama)</th>
            <td>{{ $staff->suffix_title ?? '-' }}</td>
        </tr>

        <tr>
            <th>Jantina</th>
            <td>{{ $staff->gender ?? '-' }}</td>
        </tr>

        <tr>
            <th>Tarikh Lahir</th>
            <td>{{ $staff->date_of_birth ?? '-' }}</td>
        </tr>

        <tr>
            <th>Warganegara</th>
            <td>{{ $staff->nationality ?? '-' }}</td>
        </tr>

        <tr>
            <th>Negeri Lahir</th>
            <td>{{ $staff->birth_state ?? '-' }}</td>
        </tr>

        <tr>
            <th>Bangsa</th>
            <td>{{ $staff->race ?? '-' }}</td>
        </tr>

        <tr>
            <th>Agama</th>
            <td>{{ $staff->religion ?? '-' }}</td>
        </tr>

        <tr>
            <th>Status</th>
            <td>{{ $staff->marital_status ?? '-' }}</td>
        </tr>

        <tr>
            <th>Bekas Polis/Tentera</th>
            <td>
                {{ $staff->former_police_military ? 'Ya' : 'Tidak' }}
            </td>
        </tr>

    </table>

    <br>

    {{-- Maklumat Perkhidmatan --}}
    <h2>2. Maklumat Perkhidmatan</h2>

    @forelse ($staff->serviceRecords as $record)

        <table border="1" cellpadding="8" cellspacing="0">

            <tr>
                <th>No. Staf</th>
                <td>{{ $record->staff_no }}</td>
            </tr>

            <tr>
                <th>Jurusan</th>
                <td>{{ $record->field_of_study ?? '-' }}</td>
            </tr>

            <tr>
                <th>Kumpulan</th>
                <td>{{ $record->group ?? '-' }}</td>
            </tr>

            <tr>
                <th>Klasifikasi</th>
                <td>{{ $record->classification ?? '-' }}</td>
            </tr>

            <tr>
                <th>Skim</th>
                <td>{{ $record->scheme ?? '-' }}</td>
            </tr>

            <tr>
                <th>Kategori Skim</th>
                <td>{{ $record->scheme_category ?? '-' }}</td>
            </tr>

            <tr>
                <th>Jenis Jawatan</th>
                <td>{{ $record->appointment_type ?? '-' }}</td>
            </tr>

            <tr>
                <th>Jawatan</th>
                <td>{{ $record->position ?? '-' }}</td>
            </tr>

            <tr>
                <th>Gred</th>
                <td>{{ $record->grade ?? '-' }}</td>
            </tr>

            <tr>
                <th>Bahagian</th>
                <td>{{ $record->department?->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Unit</th>
                <td>{{ $record->unit?->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Tarikh Mula Berkhidmat</th>
                <td>{{ $record->service_start_date ?? '-' }}</td>
            </tr>

            <tr>
                <th>Status Perkhidmatan</th>
                <td>{{ $record->service_status ?? '-' }}</td>
            </tr>

            <tr>
                <th>Tarikh Lantikan</th>
                <td>{{ $record->appointment_date ?? '-' }}</td>
            </tr>

            <tr>
                <th>Tarikh Pengesahan</th>
                <td>{{ $record->confirmation_date ?? '-' }}</td>
            </tr>

        </table>

    @empty

        <p>Tiada rekod perkhidmatan.</p>

    @endforelse
<hr>

<h2>3. Maklumat Tambahan</h2>

<h3>Pendidikan</h3>

{{-- Mesej berjaya --}}
@if (session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif

{{-- Senarai pendidikan --}}
@if ($staff->educations->count())

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama / Kelayakan</th>
                <th>Institusi</th>
                <th>Tahun</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($staff->educations as $education)
                <tr>
                    <td>
                        {{ $education->level }}
                    </td>

                    <td>
                        {{ $education->qualification }}
                    </td>

                    <td>
                        {{ $education->institution ?? '-' }}
                    </td>

                    <td>
                        {{ $education->year ?? '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@else

    <p>Tiada rekod pendidikan.</p>

@endif

<br>

{{-- Borang tambah pendidikan --}}
<h4>Tambah Pendidikan</h4>

<form action="{{ route('staff.educations.store', $staff) }}" method="POST">
    @csrf

    <div>
        <label for="level">Peringkat</label><br>

        <select name="level" id="level" required>
            <option value="">-- Pilih Peringkat --</option>

            <option value="Sijil">
                Sijil
            </option>

            <option value="Diploma">
                Diploma
            </option>

            <option value="Ijazah Sarjana Muda">
                Ijazah Sarjana Muda
            </option>

            <option value="Ijazah Sarjana">
                Ijazah Sarjana
            </option>

            <option value="Ijazah Doktor Falsafah">
                Ijazah Doktor Falsafah
            </option>

            <option value="Pascadoktorat">
                Pascadoktorat
            </option>

            <option value="Profesor Madya">
                Profesor Madya
            </option>

            <option value="Profesor">
                Profesor
            </option>

            <option value="Profesor Ulung">
                Profesor Ulung
            </option>
        </select>
    </div>

    <br>

    <div>
        <label for="qualification">
            Nama / Detail Kelayakan
        </label><br>

        <input
            type="text"
            name="qualification"
            id="qualification"
            placeholder="Contoh: Diploma Kejuruteraan Mekanikal"
            required
        >
    </div>

    <br>

    <div>
        <label for="institution">
            Institusi
        </label><br>

        <input
            type="text"
            name="institution"
            id="institution"
            placeholder="Contoh: Universiti Teknologi Malaysia"
        >
    </div>

    <br>

    <div>
        <label for="year">
            Tahun
        </label><br>

        <input
            type="number"
            name="year"
            id="year"
            min="1900"
            max="2200"
            placeholder="Contoh: 2015"
        >
    </div>

    <br>

    <button type="submit">
        + Simpan Pendidikan
    </button>
</form>

<hr>

<h3>Kemahiran / Special Skills</h3>

@if ($staff->skills->count())

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Kemahiran</th>
                <th>Tahap</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($staff->skills as $skill)
                <tr>
                    <td>
                        {{ $skill->skill }}
                    </td>

                    <td>
                        {{ $skill->level }}
                    </td>

                    <td>
                        {{ $skill->description ?? '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@else

    <p>Tiada rekod kemahiran.</p>

@endif

<br>

<h4>Tambah Kemahiran</h4>

<form action="{{ route('staff.skills.store', $staff) }}" method="POST">
    @csrf

    <div>
        <label for="skill">
            Kemahiran
        </label><br>

        <input
            type="text"
            name="skill"
            id="skill"
            placeholder="Contoh: AutoCAD"
            required
        >
    </div>

    <br>

    <div>
        <label for="level">
            Tahap
        </label><br>

        <select name="level" id="level" required>
            <option value="">-- Pilih Tahap --</option>

            <option value="Asas">
                Asas
            </option>

            <option value="Sederhana">
                Sederhana
            </option>

            <option value="Mahir">
                Mahir
            </option>

            <option value="Pakar">
                Pakar
            </option>
        </select>
    </div>

    <br>

    <div>
        <label for="description">
            Keterangan
        </label><br>

        <textarea
            name="description"
            id="description"
            rows="4"
            cols="50"
            placeholder="Keterangan tambahan tentang kemahiran..."
        ></textarea>
    </div>

    <br>

    <button type="submit">
        + Simpan Kemahiran
    </button>
</form>

</body>
</html>