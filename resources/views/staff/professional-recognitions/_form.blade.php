
@php
    $selectedMasterId = old(
        'professional_recognition_master_id',
        isset($professionalRecognition)
            ? $professionalRecognition->professional_recognition_master_id
            : ''
    );

    $selectedPrefix = old(
        'selected_prefix_title',
        isset($professionalRecognition)
            ? $professionalRecognition->selected_prefix_title
            : ''
    );

    $selectedSuffix = old(
        'selected_suffix_title',
        isset($professionalRecognition)
            ? $professionalRecognition->selected_suffix_title
            : ''
    );

    $masterJsData = $masters->map(fn ($master) => [
        'id' => $master->id,
        'category' => $master->regulator_category,
        'issuer' => $master->issuer,
        'scope' => $master->registration_scope,
        'level' => $master->professional_level,
        'prefix' => $master->prefix_title,
        'suffix' => $master->suffix_title,
    ])->values();
@endphp

@if ($errors->any())
    <div style="background:#fee2e2; border:1px solid #fecaca; padding:12px; margin-bottom:16px;">
        <strong>Sila semak semula:</strong>
        <ul style="margin:8px 0 0 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:16px;">
    <div>
        <label for="professional_category"><strong>Kategori Badan Kawal Selia</strong></label>
        <select id="professional_category" style="width:100%; padding:8px;" required>
            <option value="">-- Pilih Kategori --</option>
        </select>
    </div>

    <div>
        <label for="professional_issuer"><strong>Badan Pengeluar / Kawal Selia</strong></label>
        <select id="professional_issuer" style="width:100%; padding:8px;" required disabled>
            <option value="">-- Pilih Badan --</option>
        </select>
    </div>

    <div>
        <label for="professional_scope"><strong>Skop Pendaftaran</strong></label>
        <select id="professional_scope" style="width:100%; padding:8px;" required disabled>
            <option value="">-- Pilih Skop --</option>
        </select>
    </div>

    <div>
        <label for="professional_level"><strong>Nama Tahap Profesional</strong></label>
        <select id="professional_level" style="width:100%; padding:8px;" required disabled>
            <option value="">-- Pilih Tahap --</option>
        </select>
    </div>
</div>

<input
    type="hidden"
    name="professional_recognition_master_id"
    id="professional_recognition_master_id"
    value="{{ $selectedMasterId }}"
>

<div style="margin-top:18px; padding:14px; background:#f8fafc; border:1px solid #e5e7eb;">
    <strong>Gelaran daripada master</strong>
    <div style="margin-top:8px;">
        Awalan: <span id="professional_prefix_preview">-</span>
        &nbsp; | &nbsp;
        Akhiran: <span id="professional_suffix_preview">-</span>
    </div>
</div>

<div id="professional_selected_titles" style="margin-top:16px; display:none;">
    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:16px;">
        <div id="professional_prefix_field_wrap" style="display:none;">
            <label for="selected_prefix_title"><strong>Gelaran Awalan Digunakan</strong></label>
            <select
                name="selected_prefix_title"
                id="selected_prefix_title"
                style="width:100%; padding:8px;"
            ></select>
            <small>Pilih gelaran sebenar jika master mempunyai beberapa pilihan.</small>
        </div>

        <div id="professional_suffix_field_wrap" style="display:none;">
            <label for="selected_suffix_title"><strong>Gelaran Akhiran Digunakan</strong></label>
            <select
                name="selected_suffix_title"
                id="selected_suffix_title"
                style="width:100%; padding:8px;"
            ></select>
            <small>Pilih gelaran sebenar jika master mempunyai beberapa pilihan.</small>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:16px; margin-top:16px;">
    <div>
        <label for="registration_no"><strong>Reg. No.</strong></label>
        <input
            type="text"
            name="registration_no"
            id="registration_no"
            value="{{ old('registration_no', isset($professionalRecognition) ? $professionalRecognition->registration_no : '') }}"
            style="width:100%; padding:8px;"
        >
    </div>

    <div>
        <label for="registered_awarded_date"><strong>Date Registered / Date Awarded</strong></label>
        <input
            type="date"
            name="registered_awarded_date"
            id="registered_awarded_date"
            value="{{ old('registered_awarded_date', isset($professionalRecognition) && $professionalRecognition->registered_awarded_date ? $professionalRecognition->registered_awarded_date->format('Y-m-d') : '') }}"
            style="width:100%; padding:8px;"
        >
    </div>
</div>

<div style="margin-top:16px;">
    <label for="notes"><strong>Catatan</strong></label>
    <textarea
        name="notes"
        id="notes"
        rows="3"
        style="width:100%; padding:8px;"
    >{{ old('notes', isset($professionalRecognition) ? $professionalRecognition->notes : '') }}</textarea>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const masterData = @json($masterJsData);
    const initialMasterId = String(@json((string) $selectedMasterId));
    const initialPrefix = @json($selectedPrefix);
    const initialSuffix = @json($selectedSuffix);

    const category = document.getElementById('professional_category');
    const issuer = document.getElementById('professional_issuer');
    const scope = document.getElementById('professional_scope');
    const level = document.getElementById('professional_level');
    const hiddenMaster = document.getElementById('professional_recognition_master_id');

    const prefixPreview = document.getElementById('professional_prefix_preview');
    const suffixPreview = document.getElementById('professional_suffix_preview');

    const selectedTitlesWrap = document.getElementById('professional_selected_titles');
    const prefixWrap = document.getElementById('professional_prefix_field_wrap');
    const suffixWrap = document.getElementById('professional_suffix_field_wrap');
    const prefixSelect = document.getElementById('selected_prefix_title');
    const suffixSelect = document.getElementById('selected_suffix_title');

    function uniqueValues(items, field) {
        return [...new Set(items.map(item => item[field]).filter(Boolean))];
    }

    function fillSelect(select, values, placeholder, selected = '') {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        values.forEach(value => {
            const option = document.createElement('option');
            option.value = value;
            option.textContent = value;
            option.selected = String(value) === String(selected);
            select.appendChild(option);
        });
        select.disabled = values.length === 0;
    }

    function splitTitles(value) {
        if (!value || value === '—') {
            return [];
        }

        return value
            .split(' / ')
            .map(v => v.trim())
            .filter(Boolean);
    }

    function renderTitleChoice(master, initialPrefixValue = '', initialSuffixValue = '') {
        const prefixes = splitTitles(master?.prefix);
        const suffixes = splitTitles(master?.suffix);

        prefixPreview.textContent = master?.prefix || '-';
        suffixPreview.textContent = master?.suffix || '-';

        if (prefixes.length > 1) {
            fillSelect(prefixSelect, prefixes, '-- Pilih Gelaran Awalan --', initialPrefixValue);
            prefixWrap.style.display = '';
        } else {
            prefixWrap.style.display = 'none';
            prefixSelect.innerHTML = '';
        }

        if (suffixes.length > 1) {
            fillSelect(suffixSelect, suffixes, '-- Pilih Gelaran Akhiran --', initialSuffixValue);
            suffixWrap.style.display = '';
        } else {
            suffixWrap.style.display = 'none';
            suffixSelect.innerHTML = '';
        }

        selectedTitlesWrap.style.display =
            prefixes.length > 1 || suffixes.length > 1 ? '' : 'none';
    }

    const categories = uniqueValues(masterData, 'category');
    fillSelect(category, categories, '-- Pilih Kategori --');

    function resetBelow(from) {
        if (from === 'category') {
            fillSelect(issuer, [], '-- Pilih Badan --');
            fillSelect(scope, [], '-- Pilih Skop --');
            fillSelect(level, [], '-- Pilih Tahap --');
        } else if (from === 'issuer') {
            fillSelect(scope, [], '-- Pilih Skop --');
            fillSelect(level, [], '-- Pilih Tahap --');
        } else if (from === 'scope') {
            fillSelect(level, [], '-- Pilih Tahap --');
        }

        hiddenMaster.value = '';
        renderTitleChoice(null);
    }

    category.addEventListener('change', function () {
        resetBelow('category');
        const filtered = masterData.filter(item => item.category === category.value);
        fillSelect(issuer, uniqueValues(filtered, 'issuer'), '-- Pilih Badan --');
    });

    issuer.addEventListener('change', function () {
        resetBelow('issuer');
        const filtered = masterData.filter(item =>
            item.category === category.value &&
            item.issuer === issuer.value
        );
        fillSelect(scope, uniqueValues(filtered, 'scope'), '-- Pilih Skop --');
    });

    scope.addEventListener('change', function () {
        resetBelow('scope');
        const filtered = masterData.filter(item =>
            item.category === category.value &&
            item.issuer === issuer.value &&
            item.scope === scope.value
        );
        fillSelect(level, uniqueValues(filtered, 'level'), '-- Pilih Tahap --');
    });

    level.addEventListener('change', function () {
        const master = masterData.find(item =>
            item.category === category.value &&
            item.issuer === issuer.value &&
            item.scope === scope.value &&
            item.level === level.value
        );

        hiddenMaster.value = master ? master.id : '';
        renderTitleChoice(master);
    });

    if (initialMasterId) {
        const initial = masterData.find(item => String(item.id) === initialMasterId);

        if (initial) {
            category.value = initial.category;
            category.dispatchEvent(new Event('change'));

            issuer.value = initial.issuer;
            issuer.dispatchEvent(new Event('change'));

            scope.value = initial.scope;
            scope.dispatchEvent(new Event('change'));

            level.value = initial.level;
            hiddenMaster.value = initial.id;

            renderTitleChoice(initial, initialPrefix, initialSuffix);
        }
    }
});
</script>
