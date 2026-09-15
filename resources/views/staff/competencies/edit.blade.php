<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kompetensi - {{ $staff->name }}</title>
</head>
<body>

<h1>Edit Kompetensi Staf</h1>

<p>
    <a href="{{ route('staff.show', $staff) }}">
        ← Kembali ke Profil Staf
    </a>
</p>

@if ($errors->any())
    <div style="color: red;">
        <strong>Terdapat ralat pada borang:</strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form
    action="{{ route('staff.competencies.update', [$staff, $competency]) }}"
    method="POST"
>
    @csrf
    @method('PUT')

    @php
        $selectedMasterId = old(
            'competency_master_id',
            $competency->competency_master_id
        );

        $selectedMaster = $competencyMasters->firstWhere(
            'id',
            (int) $selectedMasterId
        );

        $selectedDiscipline =
            $selectedMaster?->discipline
            ?? $competency->competency?->discipline;
    @endphp

    <div>
        <label for="competency_discipline">
            Disiplin
        </label><br>

        <select id="competency_discipline">
            <option value="">-- Pilih Disiplin --</option>

            @foreach ($competencyMasters->pluck('discipline')->unique()->values() as $discipline)
                <option
                    value="{{ $discipline }}"
                    {{ $selectedDiscipline === $discipline ? 'selected' : '' }}
                >
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
                    {{
                        (string) $selectedMasterId === (string) $master->id
                        ? 'selected'
                        : ''
                    }}
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

            @foreach ([
                1 => 'Pengenalan',
                2 => 'Asas',
                3 => 'Kompeten',
                4 => 'Mahir'
            ] as $level => $label)
                <option
                    value="{{ $level }}"
                    {{
                        (string) old(
                            'competency_level',
                            $competency->competency_level
                        ) === (string) $level
                        ? 'selected'
                        : ''
                    }}
                >
                    Tahap {{ $level }} - {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label for="achievement_date">
            Tarikh Pencapaian
        </label><br>

        <input
            type="date"
            name="achievement_date"
            id="achievement_date"
            value="{{
                old(
                    'achievement_date',
                    $competency->achievement_date?->format('Y-m-d')
                    ?? $competency->achievement_date
                )
            }}"
        >
    </div>

    <br>

    <div>
        <label for="certificate_no">
            No. Sijil
        </label><br>

        <input
            type="text"
            name="certificate_no"
            id="certificate_no"
            value="{{
                old(
                    'certificate_no',
                    $competency->certificate_no
                )
            }}"
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
        >{{ old('notes', $competency->notes) }}</textarea>
    </div>

    <br>

    <button type="submit">
        Simpan Perubahan
    </button>

    <a href="{{ route('staff.show', $staff) }}">
        Batal
    </a>
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

        function filterCompetencies(resetSelection = false) {
            const selectedDiscipline = disciplineSelect.value;

            if (resetSelection) {
                competencySelect.value = '';
            }

            allOptions.forEach(function (option) {
                option.hidden =
                    selectedDiscipline !== ''
                    && option.dataset.discipline !== selectedDiscipline;
            });
        }

        filterCompetencies(false);

        disciplineSelect.addEventListener(
            'change',
            function () {
                filterCompetencies(true);
            }
        );
    });
</script>

</body>
</html>
