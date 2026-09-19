@php
    $item = $structuredSkill ?? null;

    $selectedMasterId = old(
        'skill_master_id',
        $item?->skill_master_id
    );

    $selectedMaster = $selectedMasterId
        ? \App\Models\SkillMaster::with('category.cluster')->find($selectedMasterId)
        : null;

    $selectedClusterId = $selectedMaster?->category?->cluster?->id;
    $selectedCategoryId = $selectedMaster?->category?->id;
@endphp

@if ($errors->any())
    <div style="color:#b91c1c; margin-bottom:16px;">
        <strong>Sila semak maklumat berikut:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div>
    <label for="skill_cluster_choice"><strong>Kluster</strong></label><br>
    <select id="skill_cluster_choice" required>
        <option value="">-- Pilih Kluster --</option>

        @foreach ($clusters as $cluster)
            <option
                value="{{ $cluster->id }}"
                {{ (string) $selectedClusterId === (string) $cluster->id ? 'selected' : '' }}
            >
                {{ $cluster->name }}
            </option>
        @endforeach
    </select>
</div>

<br>

<div>
    <label for="skill_category_choice"><strong>Kategori / Domain Skill</strong></label><br>

    <select id="skill_category_choice" required>
        <option value="">-- Pilih Kategori --</option>

        @foreach ($clusters as $cluster)
            @foreach ($cluster->categories as $category)
                <option
                    value="{{ $category->id }}"
                    data-cluster-id="{{ $cluster->id }}"
                    {{ (string) $selectedCategoryId === (string) $category->id ? 'selected' : '' }}
                >
                    {{ $category->name }}
                </option>
            @endforeach
        @endforeach
    </select>
</div>

<br>

<div>
    <label for="skill_master_id"><strong>Skill Spesifik / Tag</strong></label><br>

    <select
        name="skill_master_id"
        id="skill_master_id"
        required
    >
        <option value="">-- Pilih Skill --</option>

        @foreach ($clusters as $cluster)
            @foreach ($cluster->categories as $category)
                @foreach ($category->skills as $skill)
                    <option
                        value="{{ $skill->id }}"
                        data-category-id="{{ $category->id }}"
                        {{ (string) $selectedMasterId === (string) $skill->id ? 'selected' : '' }}
                    >
                        {{ $skill->name }}
                    </option>
                @endforeach
            @endforeach
        @endforeach
    </select>
</div>

<br>

<div>
    <label for="declared_level"><strong>Tahap Self-Declared</strong></label><br>

    <select name="declared_level" id="declared_level" required>
        <option value="">-- Pilih Tahap --</option>
        <option value="1" {{ (string) old('declared_level', $item?->declared_level) === '1' ? 'selected' : '' }}>
            Tahap 1 - Asas
        </option>
        <option value="2" {{ (string) old('declared_level', $item?->declared_level) === '2' ? 'selected' : '' }}>
            Tahap 2 - Berdikari
        </option>
        <option value="3" {{ (string) old('declared_level', $item?->declared_level) === '3' ? 'selected' : '' }}>
            Tahap 3 - Pakar / Rujukan
        </option>
    </select>

    <div style="margin-top:8px; max-width:700px; font-size:13px;">
        <div><strong>Tahap 1:</strong> Faham asas & buat dengan bimbingan.</div>
        <div><strong>Tahap 2:</strong> Boleh laksana sendiri tanpa pengawasan.</div>
        <div><strong>Tahap 3:</strong> Boleh bimbing orang lain & selesaikan isu kompleks.</div>
    </div>
</div>

<br>

<div>
    <label for="start_year">Tahun Mula Menggunakan Skill</label><br>
    <input
        type="number"
        name="start_year"
        id="start_year"
        min="1900"
        max="{{ now()->year }}"
        value="{{ old('start_year', $item?->start_year) }}"
    >
</div>

<br>

<div>
    <label for="years_experience">Anggaran Tahun Pengalaman</label><br>
    <input
        type="number"
        step="0.1"
        min="0"
        max="99.9"
        name="years_experience"
        id="years_experience"
        value="{{ old('years_experience', $item?->years_experience) }}"
    >
</div>

<br>

<div>
    <label for="frequency">Kekerapan Penggunaan</label><br>

    <select name="frequency" id="frequency">
        <option value="">-- Pilih --</option>

        @foreach (['Jarang','Berkala','Kerap','Sangat Kerap'] as $frequency)
            <option
                value="{{ $frequency }}"
                {{ old('frequency', $item?->frequency) === $frequency ? 'selected' : '' }}
            >
                {{ $frequency }}
            </option>
        @endforeach
    </select>
</div>

<br>

<div>
    <label for="context">Konteks Penggunaan</label><br>
    <textarea
        name="context"
        id="context"
        rows="5"
        cols="80"
        placeholder="Contoh: Menjadi pengacara majlis rasmi jabatan sejak 2021 dan moderator sesi townhall."
    >{{ old('context', $item?->context) }}</textarea>
</div>

<br>

<div>
    <label for="evidence_type">Jenis Bukti</label><br>

    <select name="evidence_type" id="evidence_type">
        <option value="">-- Pilih --</option>

        @foreach ([
            'Pengalaman sebenar',
            'Surat lantikan',
            'Projek / Program',
            'Portfolio / Hasil kerja',
            'Sijil',
            'Pengesahan penyelia',
            'Lain-lain'
        ] as $evidenceType)
            <option
                value="{{ $evidenceType }}"
                {{ old('evidence_type', $item?->evidence_type) === $evidenceType ? 'selected' : '' }}
            >
                {{ $evidenceType }}
            </option>
        @endforeach
    </select>
</div>

<br>

<div>
    <label for="evidence_description">Keterangan Bukti / Contoh Penglibatan</label><br>

    <textarea
        name="evidence_description"
        id="evidence_description"
        rows="5"
        cols="80"
        placeholder="Contoh: Mengendalikan Majlis Anugerah Jabatan 2024, moderator Seminar Teknikal 2025."
    >{{ old('evidence_description', $item?->evidence_description) }}</textarea>
</div>

<br>

<div>
    <label for="notes">Catatan</label><br>
    <textarea
        name="notes"
        id="notes"
        rows="4"
        cols="80"
    >{{ old('notes', $item?->notes) }}</textarea>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const clusterSelect = document.getElementById('skill_cluster_choice');
    const categorySelect = document.getElementById('skill_category_choice');
    const skillSelect = document.getElementById('skill_master_id');

    if (!clusterSelect || !categorySelect || !skillSelect) {
        return;
    }

    const categoryOptions = Array.from(
        categorySelect.querySelectorAll('option[data-cluster-id]')
    );

    const skillOptions = Array.from(
        skillSelect.querySelectorAll('option[data-category-id]')
    );

    function filterCategories(resetSelection = true) {
        const clusterId = clusterSelect.value;

        categoryOptions.forEach(function (option) {
            option.hidden =
                clusterId !== ''
                && option.dataset.clusterId !== clusterId;
        });

        if (
            resetSelection
            && categorySelect.selectedOptions.length
            && categorySelect.selectedOptions[0].hidden
        ) {
            categorySelect.value = '';
        }

        filterSkills(resetSelection);
    }

    function filterSkills(resetSelection = true) {
        const categoryId = categorySelect.value;

        skillOptions.forEach(function (option) {
            option.hidden =
                categoryId !== ''
                && option.dataset.categoryId !== categoryId;
        });

        if (
            resetSelection
            && skillSelect.selectedOptions.length
            && skillSelect.selectedOptions[0].hidden
        ) {
            skillSelect.value = '';
        }
    }

    clusterSelect.addEventListener('change', function () {
        categorySelect.value = '';
        skillSelect.value = '';
        filterCategories(false);
    });

    categorySelect.addEventListener('change', function () {
        skillSelect.value = '';
        filterSkills(false);
    });

    filterCategories(false);
    filterSkills(false);
});
</script>
