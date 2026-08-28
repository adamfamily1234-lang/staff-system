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
@if (session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif
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
<hr>

<h3>Kursus</h3>

@if ($staff->courses->count())
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Jenis Bidang</th>
                <th>Kategori Utama Kursus</th>
                <th>Sistem / Sub-Kategori</th>
                <th>Nama Kursus</th>
                <th>Penganjur</th>
                <th>Tarikh</th>
                <th>Tempat</th>
                <th>Catatan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($staff->courses as $course)
                <tr>
                    <td>
                        {{ $course->fieldType?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $course->mainCategory?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $course->subCategory?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $course->course_name }}
                    </td>

                    <td>
                        {{ $course->organizer ?? '-' }}
                    </td>

                    <td>
                        @if ($course->start_date)
                            {{ $course->start_date->format('d/m/Y') }}
                        @else
                            -
                        @endif

                        @if ($course->end_date)
                            hingga {{ $course->end_date->format('d/m/Y') }}
                        @endif
                    </td>

                    <td>
                        {{ $course->venue ?? '-' }}
                    </td>

                    <td>
                        {{ $course->notes ?? '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Tiada rekod kursus.</p>
@endif

<br>

<h4>Tambah Kursus</h4>

<form action="{{ route('staff.courses.store', $staff) }}" method="POST">
    @csrf

    <div>
        <label for="course_field_type_id">
            Jenis Bidang
        </label><br>

        <select
            name="course_field_type_id"
            id="course_field_type_id"
        >
            <option value="">-- Pilih Jenis Bidang --</option>

            @foreach ($courseFieldTypes as $item)
                <option value="{{ $item->id }}">
                    {{ $item->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="course_main_category_id">
            Kategori Utama Kursus
        </label><br>

        <select
            name="course_main_category_id"
            id="course_main_category_id"
        >
            <option value="">-- Pilih Kategori Utama Kursus --</option>

            @foreach ($courseMainCategories as $item)
                <option value="{{ $item->id }}">
                    {{ $item->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="course_sub_category_id">
            Sistem / Sub-Kategori
        </label><br>

        <select
            name="course_sub_category_id"
            id="course_sub_category_id"
        >
            <option value="">-- Pilih Sistem / Sub-Kategori --</option>

            @foreach ($courseSubCategories as $item)
                <option value="{{ $item->id }}">
                    {{ $item->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="course_name">
            Nama Kursus
        </label><br>

        <input
            type="text"
            name="course_name"
            id="course_name"
            required
        >
    </div>

    <br>

    <div>
        <label for="organizer">
            Penganjur
        </label><br>

        <input
            type="text"
            name="organizer"
            id="organizer"
        >
    </div>

    <br>

    <div>
        <label for="start_date">
            Tarikh Mula
        </label><br>

        <input
            type="date"
            name="start_date"
            id="start_date"
        >
    </div>

    <br>

    <div>
        <label for="end_date">
            Tarikh Tamat
        </label><br>

        <input
            type="date"
            name="end_date"
            id="end_date"
        >
    </div>

    <br>

    <div>
        <label for="venue">
            Tempat
        </label><br>

        <input
            type="text"
            name="venue"
            id="venue"
        >
    </div>

    <br>

    <div>
        <label for="notes">
            Catatan
        </label><br>

        <textarea
            name="notes"
            id="notes"
            rows="4"
            cols="50"
        ></textarea>
    </div>

    <br>

    <button type="submit">
        + Simpan Kursus
    </button>
</form>


<hr>

<h3>Anugerah</h3>

@if ($staff->awards->count())
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Anugerah</th>
                <th>Pemberi / Organisasi</th>
                <th>Tahun</th>
                <th>Peringkat</th>
                <th>Catatan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($staff->awards as $award)
                <tr>
                    <td>{{ $award->award_name }}</td>
                    <td>{{ $award->organization ?? '-' }}</td>
                    <td>{{ $award->year ?? '-' }}</td>
                    <td>{{ $award->level ?? '-' }}</td>
                    <td>{{ $award->notes ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Tiada rekod anugerah.</p>
@endif

<br>

<h4>Tambah Anugerah</h4>

<form action="{{ route('staff.awards.store', $staff) }}" method="POST">
    @csrf

    <div>
        <label for="award_name">Nama Anugerah</label><br>

        <input
            type="text"
            name="award_name"
            id="award_name"
            required
        >
    </div>

    <br>

    <div>
        <label for="organization">
            Pemberi / Organisasi
        </label><br>

        <input
            type="text"
            name="organization"
            id="organization"
        >
    </div>

    <br>

    <div>
        <label for="year">Tahun</label><br>

        <select name="year" id="year">
            <option value="">-- Pilih Tahun --</option>

            @for ($year = date('Y'); $year >= 1950; $year--)
                <option value="{{ $year }}">
                    {{ $year }}
                </option>
            @endfor
        </select>
    </div>

    <br>

    <div>
        <label for="level">Peringkat</label><br>

        <select name="level" id="level">
            <option value="">-- Pilih Peringkat --</option>
            <option value="Jabatan">Jabatan</option>
            <option value="Negeri">Negeri</option>
            <option value="Kebangsaan">Kebangsaan</option>
            <option value="Antarabangsa">Antarabangsa</option>
            <option value="Lain-lain">Lain-lain</option>
        </select>
    </div>

    <br>

    <div>
        <label for="notes">Catatan</label><br>

        <textarea
            name="notes"
            id="notes"
            rows="4"
            cols="50"
        ></textarea>
    </div>

    <br>

    <button type="submit">
        + Simpan Anugerah
    </button>
</form>

<hr>

<h3>Sejarah Penempatan</h3>

@if ($staff->placements->count())
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Gred</th>
                <th>Status Gred</th>
                <th>Jawatan</th>
                <th>Jenis Penempatan</th>
                <th>Bahagian</th>
                <th>Unit</th>
                <th>Tarikh Mula</th>
                <th>Tarikh Tamat</th>
                <th>Tempoh</th>
                <th>Status Penempatan</th>
                <th>Catatan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($staff->placements as $placement)

                @php
                    $start = $placement->start_date;
                    $end = $placement->end_date ?? now();

                    $diff = $start
                        ? $start->diff($end)
                        : null;
                @endphp

                <tr>
                    <td>
                        {{ $placement->grade?->grade_code ?? '-' }}
                    </td>

                    <td>
                        {{ $placement->grade_status }}
                    </td>

                    <td>
                        {{ $placement->position?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $placement->placementType?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $placement->department?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $placement->unit?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $placement->start_date?->format('d/m/Y') ?? '-' }}
                    </td>

                    <td>
                        {{ $placement->end_date?->format('d/m/Y') ?? 'Semasa' }}
                    </td>

                    <td>
                        @if ($diff)
                            {{ $diff->y }} Tahun
                            {{ $diff->m }} Bulan
                            {{ $diff->d }} Hari
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        {{ $placement->end_date ? 'Tamat' : 'Semasa' }}
                    </td>                    
                    <td>
                        {{ $placement->notes ?? '-' }}
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

@else
    <p>Tiada rekod penempatan.</p>
@endif


<hr>

<h3>Ringkasan Kekananan</h3>

@if ($latestHakikiPlacement)

    @php
        $hakikiStart = $latestHakikiPlacement->start_date;
        $hakikiEnd = $latestHakikiPlacement->end_date ?? now();

        $hakikiDiff = $hakikiStart
            ? $hakikiStart->diff($hakikiEnd)
            : null;
    @endphp

    <table border="1" cellpadding="10" cellspacing="0">

        <tr>
            <th>Gred Hakiki Tertinggi</th>
            <td>
                {{ $latestHakikiPlacement->grade?->grade_code ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Tarikh Mula Hakiki</th>
            <td>
                {{ $latestHakikiPlacement->start_date?->format('d/m/Y') ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Tempoh Dalam Gred Hakiki</th>
            <td>
                @if ($hakikiDiff)
                    {{ $hakikiDiff->y }} Tahun
                    {{ $hakikiDiff->m }} Bulan
                    {{ $hakikiDiff->d }} Hari
                @else
                    -
                @endif
            </td>
        </tr>

        <tr>
            <th>Jawatan</th>
            <td>
                {{ $latestHakikiPlacement->position?->name ?? '-' }}
            </td>
        </tr>

    </table>

@else
    <p>Tiada rekod gred Hakiki.</p>
@endif
<br>

<h4>Tambah Rekod Penempatan</h4>

<form action="{{ route('staff.placements.store', $staff) }}" method="POST">
    @csrf

    <div>
        <label for="grade_master_id">Gred</label><br>

        <select
            name="grade_master_id"
            id="grade_master_id"
            required
        >
            <option value="">-- Pilih Gred --</option>

            @foreach ($gradeMasters as $grade)
                <option value="{{ $grade->id }}">
                    {{ $grade->grade_code }}
                    -
                    {{ $grade->grade_category }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="grade_status">Status Gred</label><br>

        <select
            name="grade_status"
            id="grade_status"
            required
        >
            <option value="">-- Pilih Status --</option>
            <option value="Hakiki">Hakiki</option>
            <option value="Memangku">Memangku</option>
        </select>
    </div>

    <br>

    <div>
        <label for="position_master_id">Jawatan</label><br>

        <select
            name="position_master_id"
            id="position_master_id"
        >
            <option value="">-- Pilih Jawatan --</option>

            @foreach ($positionMasters as $position)
                <option value="{{ $position->id }}">
                    {{ $position->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="placement_type_master_id">
            Jenis Penempatan
        </label><br>

        <select
            name="placement_type_master_id"
            id="placement_type_master_id"
        >
            <option value="">-- Pilih Jenis Penempatan --</option>

            @foreach ($placementTypeMasters as $placementType)
                <option value="{{ $placementType->id }}">
                    {{ $placementType->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="placement_department_id">
            Bahagian
        </label><br>

        <select
            name="department_id"
            id="placement_department_id"
        >
            <option value="">-- Pilih Bahagian --</option>

            @foreach ($departments ?? [] as $department)
                <option value="{{ $department->id }}">
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="placement_unit_id">
            Unit
        </label><br>

        <select
            name="unit_id"
            id="placement_unit_id"
        >
            <option value="">-- Pilih Unit --</option>
        </select>
    </div>

    <br>

    <div>
        <label for="placement_start_date">
            Tarikh Mula
        </label><br>

        <input
            type="date"
            name="start_date"
            id="placement_start_date"
            required
        >
    </div>

    <br>

    <div>
        <label for="placement_end_date">
            Tarikh Tamat
        </label><br>

        <input
            type="date"
            name="end_date"
            id="placement_end_date"
        >

        <small>
            Kosongkan jika ini penempatan semasa.
        </small>
    </div>

    <br>

    <div>
    <label for="placement_notes_select">
        Catatan
    </label><br>

    <select
        id="placement_notes_select"
    >
        <option value="">-- Pilih Catatan --</option>

        <option value="Pertukaran atas keperluan jabatan">
            Pertukaran atas keperluan jabatan
        </option>

        <option value="Penempatan kader">
            Penempatan kader
        </option>

        <option value="Pertukaran antara unit">
            Pertukaran antara unit
        </option>

        <option value="Kenaikan pangkat">
            Kenaikan pangkat
        </option>

        <option value="Lain-lain">
            Lain-lain
        </option>
    </select>
</div>

<br>

<div
    id="placement_notes_other_container"
    style="display: none;"
>
    <label for="placement_notes_other">
        Catatan Lain-lain
    </label><br>

    <textarea
        id="placement_notes_other"
        rows="4"
        cols="50"
        placeholder="Taip catatan lain di sini..."
    ></textarea>
</div>

<input
    type="hidden"
    name="notes"
    id="placement_notes"
>

    <br>

    <button type="submit">
        + Simpan Penempatan
    </button>
</form>


<script>
    const placementDepartment = document.getElementById('placement_department_id');
    const placementUnit = document.getElementById('placement_unit_id');

    if (placementDepartment && placementUnit) {

        placementDepartment.addEventListener('change', async function () {

            const departmentId = this.value;

            placementUnit.innerHTML =
                '<option value="">-- Pilih Unit --</option>';

            if (!departmentId) {
                return;
            }

            try {
                const response = await fetch(
                    `/departments/${departmentId}/units`
                );

                if (!response.ok) {
                    throw new Error('Gagal mendapatkan senarai unit.');
                }

                const units = await response.json();

                units.forEach(function (unit) {

                    const option = document.createElement('option');

                    option.value = unit.id;
                    option.textContent = unit.name;

                    placementUnit.appendChild(option);
                });

            } catch (error) {

                console.error(error);

                alert('Tidak dapat memuatkan senarai unit.');
            }
        });
    }

    const placementNotesSelect =
    document.getElementById('placement_notes_select');

const placementNotesOtherContainer =
    document.getElementById('placement_notes_other_container');

const placementNotesOther =
    document.getElementById('placement_notes_other');

const placementNotes =
    document.getElementById('placement_notes');

if (
    placementNotesSelect &&
    placementNotesOtherContainer &&
    placementNotesOther &&
    placementNotes
) {

    placementNotesSelect.addEventListener('change', function () {

        if (this.value === 'Lain-lain') {

            placementNotesOtherContainer.style.display = 'block';

            placementNotes.value =
                placementNotesOther.value;

        } else {

            placementNotesOtherContainer.style.display = 'none';

            placementNotesOther.value = '';

            placementNotes.value =
                this.value;
        }
    });

    placementNotesOther.addEventListener('input', function () {

        if (placementNotesSelect.value === 'Lain-lain') {
            placementNotes.value = this.value;
        }

    });
}
</script>

</body>
</html>