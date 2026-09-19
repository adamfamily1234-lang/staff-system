<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil Staf - {{ $staff->display_name }}</title>
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
           <td>{{ $staff->display_name }}</td>
        </tr>

        <tr>
            <th>No. KP</th>
            <td>{{ $staff->ic_no }}</td>
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
                <th>Jawatan Semasa</th>
    <td>
        {{ $currentPlacement?->position?->name ?? $record->position ?? '-' }}
    </td>
</tr>

<tr>
    <th>Gred Semasa</th>
    <td>
        {{ $currentPlacement?->grade?->grade_code ?? $record->grade ?? '-' }}
    </td>
</tr>

<tr>
    <th>Bahagian Semasa</th>
    <td>
        {{ $currentPlacement?->department?->name ?? $record->department?->name ?? '-' }}
    </td>
</tr>

<tr>
    <th>Unit Semasa</th>
    <td>
        {{ $currentPlacement?->unit?->name ?? $record->unit?->name ?? '-' }}
    </td>
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
                <th>Tindakan</th>
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

                    <td>
                        <a href="{{ route('staff.educations.edit', [$staff, $education]) }}">
                            Edit
                        </a>

                        <form
                            action="{{ route('staff.educations.destroy', [$staff, $education]) }}"
                            method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('Padam rekod pendidikan ini?');"
                        >
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
                <th>Tindakan</th>
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

                    <td>
                        <a href="{{ route('staff.skills.edit', [$staff, $skill]) }}">
                            Edit
                        </a>

                        <form
                            action="{{ route('staff.skills.destroy', [$staff, $skill]) }}"
                            method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('Padam rekod kemahiran ini?');"
                        >
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
                <th>Tindakan</th>
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

                    <td>
                        <a href="{{ route('staff.courses.edit', [$staff, $course]) }}">
                            Edit
                        </a>

                        <form
                            action="{{ route('staff.courses.destroy', [$staff, $course]) }}"
                            method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('Padam rekod kursus ini?');"
                        >
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
                <th>Tindakan</th>
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
                    <td>
                        <a href="{{ route('staff.awards.edit', [$staff, $award]) }}">
                            Edit
                        </a>

                        <form
                            action="{{ route('staff.awards.destroy', [$staff, $award]) }}"
                            method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('Padam rekod anugerah ini?');"
                        >
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



<h3>Kompetensi</h3>

@if ($staff->competencies->count())
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Disiplin</th>
                <th>Kod</th>
                <th>Bidang / Domain</th>
                <th>Tajuk Kompetensi</th>
                <th>Tahap</th>
                <th>Tarikh Pencapaian</th>
                <th>No. Sijil</th>
                <th>Catatan</th>
                <th>Tindakan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($staff->competencies as $staffCompetency)
                @php
                    $levelLabels = [
                        1 => 'Pengenalan',
                        2 => 'Asas',
                        3 => 'Kompeten',
                        4 => 'Mahir',
                    ];
                @endphp

                <tr>
                    <td>{{ $staffCompetency->competency?->discipline ?? '-' }}</td>
                    <td>{{ $staffCompetency->competency?->code ?? '-' }}</td>
                    <td>{{ $staffCompetency->competency?->domain ?? '-' }}</td>
                    <td>{{ $staffCompetency->competency?->competency_title ?? '-' }}</td>

                    <td>
                        Tahap {{ $staffCompetency->competency_level }}
                        -
                        {{ $levelLabels[$staffCompetency->competency_level] ?? '-' }}
                    </td>

                    <td>
                        {{ $staffCompetency->achievement_date?->format('d/m/Y') ?? '-' }}
                    </td>

                    <td>{{ $staffCompetency->certificate_no ?? '-' }}</td>
                    <td>{{ $staffCompetency->notes ?? '-' }}</td>

                    <td>
                        <a href="{{ route('staff.competencies.edit', [$staff, $staffCompetency]) }}">
                            Edit
                        </a>

                        <form
                            action="{{ route('staff.competencies.destroy', [$staff, $staffCompetency]) }}"
                            method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('Padam rekod kompetensi ini?');"
                        >
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
    <p>Tiada rekod kompetensi.</p>
@endif

<br>

<h4>Tambah Kompetensi</h4>

<form action="{{ route('staff.competencies.store', $staff) }}" method="POST">
    @csrf

    <div>
        <label for="competency_discipline">
            Disiplin
        </label><br>

        <select id="competency_discipline">
            <option value="">-- Pilih Disiplin --</option>

            @foreach ($competencyMasters->pluck('discipline')->unique()->values() as $discipline)
                <option value="{{ $discipline }}">
                    {{ $discipline }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="competency_master_id">
            Kod / Bidang / Tajuk Kompetensi
        </label><br>

        <select
            name="competency_master_id"
            id="competency_master_id"
            required
        >
            <option value="">-- Pilih Kompetensi --</option>

            @foreach ($competencyMasters as $master)
                <option
                    value="{{ $master->id }}"
                    data-discipline="{{ $master->discipline }}"
                >
                    {{ $master->code }}
                    -
                    {{ $master->domain }}
                    -
                    {{ $master->competency_title }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="competency_level">
            Tahap Kompetensi
        </label><br>

        <select
            name="competency_level"
            id="competency_level"
            required
        >
            <option value="">-- Pilih Tahap --</option>
            <option value="1">Tahap 1 - Pengenalan</option>
            <option value="2">Tahap 2 - Asas</option>
            <option value="3">Tahap 3 - Kompeten</option>
            <option value="4">Tahap 4 - Mahir</option>
        </select>
    </div>

    <br>

    <div>
        <label for="competency_achievement_date">
            Tarikh Pencapaian
        </label><br>

        <input
            type="date"
            name="achievement_date"
            id="competency_achievement_date"
        >
    </div>

    <br>

    <div>
        <label for="competency_certificate_no">
            No. Sijil
        </label><br>

        <input
            type="text"
            name="certificate_no"
            id="competency_certificate_no"
        >
    </div>

    <br>

    <div>
        <label for="competency_notes">
            Catatan
        </label><br>

        <textarea
            name="notes"
            id="competency_notes"
            rows="4"
            cols="50"
        ></textarea>
    </div>

    <br>

    <button type="submit">
        + Simpan Kompetensi
    </button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const disciplineSelect =
            document.getElementById('competency_discipline');

        const competencySelect =
            document.getElementById('competency_master_id');

        if (!disciplineSelect || !competencySelect) {
            return;
        }

        const allOptions = Array.from(
            competencySelect.querySelectorAll(
                'option[data-discipline]'
            )
        );

        function filterCompetencies() {
            const selectedDiscipline = disciplineSelect.value;

            competencySelect.value = '';

            allOptions.forEach(function (option) {
                option.hidden =
                    selectedDiscipline !== ''
                    && option.dataset.discipline !== selectedDiscipline;
            });
        }

        disciplineSelect.addEventListener(
            'change',
            filterCompetencies
        );
    });
</script>

<hr>


<h3>Pengalaman Kerja</h3>


<h4>Ringkasan / Ranking Pengalaman</h4>

@if ($experienceRanking->count())
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Kategori Bidang Utama</th>
                <th>Jumlah Tempoh</th>
                <th>Bil. Rekod</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($experienceRanking as $index => $rank)
                @php
                    $totalDays = (int) $rank['total_days'];
                    $years = intdiv($totalDays, 365);
                    $remainingDays = $totalDays % 365;
                    $months = intdiv($remainingDays, 30);
                    $days = $remainingDays % 30;
                @endphp

                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $rank['category'] }}</td>

                    <td>
                        {{ $years }} Tahun
                        {{ $months }} Bulan
                        {{ $days }} Hari
                    </td>

                    <td>{{ $rank['record_count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Belum ada ringkasan pengalaman.</p>
@endif

<br>


@php
    $sortedWorkExperiences = $staff->workExperiences
        ->map(function ($item) {
            $start = $item->start_date;
            $end = $item->end_date ?? now();

            $item->duration_days = $start
                ? $start->diffInDays($end)
                : 0;

            return $item;
        })
        ->sortByDesc('duration_days')
        ->values();
@endphp

@if ($sortedWorkExperiences->count())
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Jenis Bidang</th>
                <th>Kategori Bidang Utama</th>
                <th>Kategori Sistem Utama</th>
                <th>Sistem / Sub-Bidang</th>
                <th>Kementerian / Jabatan</th>
                <th>Lokasi / Bahagian</th>
                <th>Tarikh Mula</th>
                <th>Tarikh Tamat</th>
                <th>Tempoh</th>
                <th>Catatan</th>
                <th>Tindakan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($sortedWorkExperiences as $experience)
                @php
                    $startDate = $experience->start_date;
                    $endDate = $experience->end_date ?? now();

                    $duration = $startDate
                        ? $startDate->diff($endDate)
                        : null;

                    $displayFieldType =
                        $experience->field_type
                        ?? $experience->experienceMaster?->field_type
                        ?? '-';

                    $displayMainCategory =
                        $experience->mainCategory?->name
                        ?? $experience->other_main_category
                        ?? '-';

                    $displaySystemCategory =
                        $experience->system_category
                        ?? $experience->other_system_category
                        ?? $experience->experienceMaster?->main_system_category
                        ?? '-';

                    $displaySubField =
                        $experience->experienceMaster?->sub_field
                        ?? $experience->other_sub_field
                        ?? $experience->other_experience
                        ?? '-';
                @endphp

                <tr>
                    <td>{{ $displayFieldType }}</td>
                    <td>{{ $displayMainCategory }}</td>
                    <td>{{ $displaySystemCategory }}</td>
                    <td>{{ $displaySubField }}</td>

                    <td>{{ $experience->ministry_department ?? '-' }}</td>
                    <td>{{ $experience->location_division ?? '-' }}</td>

                    <td>
                        {{ $experience->start_date?->format('d/m/Y') ?? '-' }}
                    </td>

                    <td>
                        {{
                            $experience->end_date
                            ? $experience->end_date->format('d/m/Y')
                            : 'Semasa'
                        }}
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

                    <td>{{ $experience->notes ?? '-' }}</td>

                    <td>
                        <a href="{{ route('staff.work-experiences.edit', [$staff, $experience]) }}">
                            Edit
                        </a>

                        <form
                            action="{{ route('staff.work-experiences.destroy', [$staff, $experience]) }}"
                            method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('Padam rekod pengalaman kerja ini?');"
                        >
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
    <p>Tiada rekod pengalaman kerja.</p>
@endif

<br>

<h4>Tambah Pengalaman Kerja</h4>

<form action="{{ route('staff.work-experiences.store', $staff) }}" method="POST">
    @csrf

    <div>
        <label for="experience_field_type">
            Jenis Bidang
        </label><br>

        <select
            name="field_type"
            id="experience_field_type"
            required
        >
            <option value="">-- Pilih Jenis Bidang --</option>

            @foreach ($experienceMasters->pluck('field_type')->unique()->values() as $fieldType)
                <option
                    value="{{ $fieldType }}"
                    {{ old('field_type') === $fieldType ? 'selected' : '' }}
                >
                    {{ $fieldType }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="experience_main_category_choice">
            Kategori Bidang Utama
        </label><br>

        <select
            id="experience_main_category_choice"
            required
        >
            <option value="">-- Pilih Kategori Bidang Utama --</option>

            @foreach ($experienceMainCategories as $category)
                <option
                    value="{{ $category->id }}"
                    data-field-type="{{ $category->field_type }}"
                >
                    {{ $category->name }}
                </option>
            @endforeach

            <option value="__other__">Lain-lain</option>
        </select>

        <input
            type="hidden"
            name="experience_main_category_id"
            id="experience_main_category_id"
            value="{{ old('experience_main_category_id') }}"
        >
    </div>

    <div
        id="other_main_category_wrapper"
        style="display:none; margin-top:8px;"
    >
        <label for="other_main_category">
            Nyatakan Kategori Bidang Utama
        </label><br>

        <input
            type="text"
            name="other_main_category"
            id="other_main_category"
            maxlength="255"
            value="{{ old('other_main_category') }}"
        >
    </div>

    <br>

    <div>
        <label for="experience_system_category_choice">
            Kategori Sistem Utama
        </label><br>

        <select
            id="experience_system_category_choice"
            required
        >
            <option value="">-- Pilih Kategori Sistem Utama --</option>
        </select>

        <input
            type="hidden"
            name="system_category"
            id="system_category"
            value="{{ old('system_category') }}"
        >
    </div>

    <div
        id="other_system_category_wrapper"
        style="display:none; margin-top:8px;"
    >
        <label for="other_system_category">
            Nyatakan Kategori Sistem Utama
        </label><br>

        <input
            type="text"
            name="other_system_category"
            id="other_system_category"
            maxlength="255"
            value="{{ old('other_system_category') }}"
        >
    </div>

    <br>

    <div>
        <label for="experience_sub_field_choice">
            Sistem / Sub-Bidang
        </label><br>

        <select
            id="experience_sub_field_choice"
            required
        >
            <option value="">-- Pilih Sistem / Sub-Bidang --</option>
        </select>

        <input
            type="hidden"
            name="experience_master_id"
            id="experience_master_id"
            value="{{ old('experience_master_id') }}"
        >
    </div>

    <div
        id="other_sub_field_wrapper"
        style="display:none; margin-top:8px;"
    >
        <label for="other_sub_field">
            Nyatakan Sistem / Sub-Bidang
        </label><br>

        <input
            type="text"
            name="other_sub_field"
            id="other_sub_field"
            maxlength="255"
            value="{{ old('other_sub_field') }}"
        >
    </div>

    <br>

    <div>
        <label for="ministry_department">
            Kementerian / Jabatan
        </label><br>

        <input
            type="text"
            name="ministry_department"
            id="ministry_department"
            value="{{ old('ministry_department') }}"
        >
    </div>

    <br>

    <div>
        <label for="location_division">
            Lokasi / Bahagian
        </label><br>

        <input
            type="text"
            name="location_division"
            id="location_division"
            value="{{ old('location_division') }}"
        >
    </div>

    <br>

    <div>
        <label for="work_start_date">
            Tarikh Mula Penglibatan
        </label><br>

        <input
            type="date"
            name="start_date"
            id="work_start_date"
            value="{{ old('start_date') }}"
            required
        >
    </div>

    <br>

    <div>
        <label for="work_end_date">
            Tarikh Tamat Penglibatan
        </label><br>

        <input
            type="date"
            name="end_date"
            id="work_end_date"
            value="{{ old('end_date') }}"
        >

        <br>
        <small>
            Biarkan kosong jika pengalaman masih berjalan.
        </small>
    </div>

    <br>

    <div>
        <label for="work_notes">
            Catatan
        </label><br>

        <textarea
            name="notes"
            id="work_notes"
            rows="4"
            cols="50"
        >{{ old('notes') }}</textarea>
    </div>

    <br>

    <button type="submit">
        + Simpan Pengalaman Kerja
    </button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fieldTypeSelect =
        document.getElementById('experience_field_type');

    const mainChoice =
        document.getElementById(
            'experience_main_category_choice'
        );

    const mainId =
        document.getElementById(
            'experience_main_category_id'
        );

    const otherMainWrapper =
        document.getElementById(
            'other_main_category_wrapper'
        );

    const otherMainInput =
        document.getElementById('other_main_category');

    const systemChoice =
        document.getElementById(
            'experience_system_category_choice'
        );

    const systemValue =
        document.getElementById('system_category');

    const otherSystemWrapper =
        document.getElementById(
            'other_system_category_wrapper'
        );

    const otherSystemInput =
        document.getElementById('other_system_category');

    const subChoice =
        document.getElementById(
            'experience_sub_field_choice'
        );

    const masterId =
        document.getElementById('experience_master_id');

    const otherSubWrapper =
        document.getElementById(
            'other_sub_field_wrapper'
        );

    const otherSubInput =
        document.getElementById('other_sub_field');

    const allMainOptions = Array.from(
        mainChoice.querySelectorAll(
            'option[data-field-type]'
        )
    );

    @php
        $experienceMasterJsData = $experienceMasters
            ->map(function ($master) {
                return [
                    'id' => $master->id,
                    'field_type' => $master->field_type,
                    'system_category' =>
                        $master->main_system_category,
                    'sub_field' =>
                        $master->sub_field
                        ?? $master->main_system_category,
                ];
            })
            ->values();
    @endphp

    const masterData = @json($experienceMasterJsData);

    function unique(values) {
        return [...new Set(values.filter(Boolean))];
    }

    function clearSelect(select, placeholder) {
        select.innerHTML =
            `<option value="">${placeholder}</option>`;
    }

    function addOtherOption(select) {
        const option = document.createElement('option');
        option.value = '__other__';
        option.textContent = 'Lain-lain';
        select.appendChild(option);
    }

    function setManual(wrapper, input, enabled) {
        wrapper.style.display =
            enabled ? 'block' : 'none';

        input.required = enabled;

        if (!enabled) {
            input.value = '';
        }
    }

    function loadMainCategories() {
        const fieldType = fieldTypeSelect.value;

        mainChoice.value = '';
        mainId.value = '';
        setManual(
            otherMainWrapper,
            otherMainInput,
            false
        );

        allMainOptions.forEach(function (option) {
            option.hidden =
                !fieldType
                || option.dataset.fieldType !== fieldType;
        });

        loadSystemCategories();
    }

    function handleMainCategory() {
        if (mainChoice.value === '__other__') {
            mainId.value = '';
            setManual(
                otherMainWrapper,
                otherMainInput,
                true
            );
        } else {
            mainId.value = mainChoice.value;
            setManual(
                otherMainWrapper,
                otherMainInput,
                false
            );
        }
    }

    function loadSystemCategories() {
        const fieldType = fieldTypeSelect.value;

        clearSelect(
            systemChoice,
            '-- Pilih Kategori Sistem Utama --'
        );

        systemValue.value = '';
        setManual(
            otherSystemWrapper,
            otherSystemInput,
            false
        );

        if (fieldType) {
            unique(
                masterData
                    .filter(
                        item =>
                            item.field_type === fieldType
                    )
                    .map(
                        item => item.system_category
                    )
            ).forEach(function (value) {
                const option =
                    document.createElement('option');

                option.value = value;
                option.textContent = value;

                systemChoice.appendChild(option);
            });

            addOtherOption(systemChoice);
        }

        loadSubFields();
    }

    function handleSystemCategory() {
        if (systemChoice.value === '__other__') {
            systemValue.value = '';

            setManual(
                otherSystemWrapper,
                otherSystemInput,
                true
            );
        } else {
            systemValue.value = systemChoice.value;

            setManual(
                otherSystemWrapper,
                otherSystemInput,
                false
            );
        }

        loadSubFields();
    }

    function loadSubFields() {
        const fieldType = fieldTypeSelect.value;
        const selectedSystem = systemChoice.value;

        clearSelect(
            subChoice,
            '-- Pilih Sistem / Sub-Bidang --'
        );

        masterId.value = '';

        setManual(
            otherSubWrapper,
            otherSubInput,
            false
        );

        if (!fieldType || !selectedSystem) {
            return;
        }

        if (selectedSystem !== '__other__') {
            masterData
                .filter(
                    item =>
                        item.field_type === fieldType
                        && item.system_category ===
                            selectedSystem
                )
                .forEach(function (item) {
                    const option =
                        document.createElement('option');

                    option.value = item.id;
                    option.textContent = item.sub_field;

                    subChoice.appendChild(option);
                });
        }

        addOtherOption(subChoice);
    }

    function handleSubField() {
        if (subChoice.value === '__other__') {
            masterId.value = '';

            setManual(
                otherSubWrapper,
                otherSubInput,
                true
            );
        } else {
            masterId.value = subChoice.value;

            setManual(
                otherSubWrapper,
                otherSubInput,
                false
            );
        }
    }

    fieldTypeSelect.addEventListener(
        'change',
        loadMainCategories
    );

    mainChoice.addEventListener(
        'change',
        handleMainCategory
    );

    systemChoice.addEventListener(
        'change',
        handleSystemCategory
    );

    subChoice.addEventListener(
        'change',
        handleSubField
    );

    if (fieldTypeSelect.value) {
        loadMainCategories();
    }
});
</script>

<hr>
@include('staff.partials.professional-recognitions', ['staff' => $staff])

@include('staff.partials.honorary-titles', ['staff' => $staff])

@include('staff.partials.professional-contributions', ['staff' => $staff])

<h3>Penempatan Semasa</h3>

@if ($currentPlacement)

    @php
        $currentStart = $currentPlacement->start_date;
        $currentEnd = now();

        $currentDiff = $currentStart
            ? $currentStart->diff($currentEnd)
            : null;
    @endphp

    <table border="1" cellpadding="10" cellspacing="0">

        <tr>
            <th>Gred</th>
            <td>
                {{ $currentPlacement->grade?->grade_code ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Status Gred</th>
            <td>
                {{ $currentPlacement->grade_status ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Jawatan</th>
            <td>
                {{ $currentPlacement->position?->name ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Jenis Penempatan</th>
            <td>
                {{ $currentPlacement->placementType?->name ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Bahagian</th>
            <td>
                {{ $currentPlacement->department?->name ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Unit</th>
            <td>
                {{ $currentPlacement->unit?->name ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Tarikh Mula</th>
            <td>
                {{ $currentPlacement->start_date?->format('d/m/Y') ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Tempoh Semasa</th>
            <td>
                @if ($currentDiff)
                    {{ $currentDiff->y }} Tahun
                    {{ $currentDiff->m }} Bulan
                    {{ $currentDiff->d }} Hari
                @else
                    -
                @endif
            </td>
        </tr>

        <tr>
            <th>Catatan</th>
            <td>
                {{ $currentPlacement->notes ?? '-' }}
            </td>
        </tr>

    </table>

@else

    <p>Tiada rekod penempatan semasa.</p>

@endif
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
                <th>Tindakan</th>
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

                    <td>
                        <a href="{{ route('staff.placements.edit', [$staff, $placement]) }}">
                            Edit
                        </a>

                        <form
                            action="{{ route('staff.placements.destroy', [$staff, $placement]) }}"
                            method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('Padam rekod penempatan ini? Kronologi tarikh tamat akan dikira semula secara automatik.');"
                        >
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
    <p>Tiada rekod penempatan.</p>
@endif


<hr>

<h3>Ringkasan Kekananan</h3>

@if ($latestHakikiPlacement)

    @php
        $hakikiDiff = $hakikiStartDate
            ? $hakikiStartDate->diff(now())
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
                {{ $hakikiStartDate?->format('d/m/Y') ?? '-' }}
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