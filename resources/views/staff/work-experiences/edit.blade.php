<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengalaman Kerja - {{ $staff->name }}</title>
</head>
<body>

<h1>Edit Pengalaman Kerja</h1>

<p>
    <a href="{{ route('staff.show', $staff) }}">
        ← Kembali ke Profil Staf
    </a>
</p>

@if ($errors->any())
    <div style="color:red;">
        <strong>Terdapat ralat pada borang:</strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $selectedFieldType = old(
        'field_type',
        $workExperience->field_type
        ?? $workExperience->experienceMaster?->field_type
    );

    $selectedMainId = old(
        'experience_main_category_id',
        $workExperience->experience_main_category_id
    );

    $selectedOtherMain = old(
        'other_main_category',
        $workExperience->other_main_category
    );

    $selectedSystem = old(
        'system_category',
        $workExperience->system_category
        ?? $workExperience->experienceMaster?->main_system_category
    );

    $selectedOtherSystem = old(
        'other_system_category',
        $workExperience->other_system_category
    );

    $selectedMasterId = old(
        'experience_master_id',
        $workExperience->experience_master_id
    );

    $selectedOtherSub = old(
        'other_sub_field',
        $workExperience->other_sub_field
        ?? $workExperience->other_experience
    );
@endphp

<form
    action="{{ route('staff.work-experiences.update', [$staff, $workExperience]) }}"
    method="POST"
>
    @csrf
    @method('PUT')

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
                    {{ $selectedFieldType === $fieldType ? 'selected' : '' }}
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
            value="{{ $selectedMainId }}"
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
            value="{{ $selectedOtherMain }}"
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
            value="{{ $selectedSystem }}"
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
            value="{{ $selectedOtherSystem }}"
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
            value="{{ $selectedMasterId }}"
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
            value="{{ $selectedOtherSub }}"
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
            value="{{ old('ministry_department', $workExperience->ministry_department) }}"
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
            value="{{ old('location_division', $workExperience->location_division) }}"
        >
    </div>

    <br>

    <div>
        <label for="start_date">
            Tarikh Mula Penglibatan
        </label><br>

        <input
            type="date"
            name="start_date"
            id="start_date"
            required
            value="{{ old('start_date', $workExperience->start_date?->format('Y-m-d')) }}"
        >
    </div>

    <br>

    <div>
        <label for="end_date">
            Tarikh Tamat Penglibatan
        </label><br>

        <input
            type="date"
            name="end_date"
            id="end_date"
            value="{{ old('end_date', $workExperience->end_date?->format('Y-m-d')) }}"
        >

        <br>
        <small>
            Biarkan kosong jika pengalaman masih berjalan.
        </small>
    </div>

    <br>

    <div>
        <label for="notes">Catatan</label><br>

        <textarea
            name="notes"
            id="notes"
            rows="4"
            cols="50"
        >{{ old('notes', $workExperience->notes) }}</textarea>
    </div>

    <br>

    <button type="submit">Simpan Perubahan</button>

    <a href="{{ route('staff.show', $staff) }}">
        Batal
    </a>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const initial = {
        fieldType: @json($selectedFieldType),
        mainId: @json((string) $selectedMainId),
        otherMain: @json($selectedOtherMain),
        system: @json($selectedSystem),
        otherSystem: @json($selectedOtherSystem),
        masterId: @json((string) $selectedMasterId),
        otherSub: @json($selectedOtherSub),
    };

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
    }

    function loadMainCategories(restore = false) {
        const fieldType = fieldTypeSelect.value;

        allMainOptions.forEach(function (option) {
            option.hidden =
                !fieldType
                || option.dataset.fieldType !== fieldType;
        });

        if (restore) {
            if (initial.otherMain) {
                mainChoice.value = '__other__';
                mainId.value = '';

                setManual(
                    otherMainWrapper,
                    otherMainInput,
                    true
                );
            } else if (initial.mainId) {
                mainChoice.value = initial.mainId;
                mainId.value = initial.mainId;

                setManual(
                    otherMainWrapper,
                    otherMainInput,
                    false
                );
            }
        } else {
            mainChoice.value = '';
            mainId.value = '';
            otherMainInput.value = '';

            setManual(
                otherMainWrapper,
                otherMainInput,
                false
            );
        }
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
            otherMainInput.value = '';

            setManual(
                otherMainWrapper,
                otherMainInput,
                false
            );
        }
    }

    function loadSystemCategories(restore = false) {
        const fieldType = fieldTypeSelect.value;

        clearSelect(
            systemChoice,
            '-- Pilih Kategori Sistem Utama --'
        );

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
            const option = document.createElement('option');
            option.value = value;
            option.textContent = value;
            systemChoice.appendChild(option);
        });

        if (fieldType) {
            addOtherOption(systemChoice);
        }

        if (restore) {
            if (initial.otherSystem) {
                systemChoice.value = '__other__';
                systemValue.value = '';

                setManual(
                    otherSystemWrapper,
                    otherSystemInput,
                    true
                );
            } else if (initial.system) {
                systemChoice.value = initial.system;
                systemValue.value = initial.system;

                setManual(
                    otherSystemWrapper,
                    otherSystemInput,
                    false
                );
            }
        } else {
            systemChoice.value = '';
            systemValue.value = '';
            otherSystemInput.value = '';

            setManual(
                otherSystemWrapper,
                otherSystemInput,
                false
            );
        }
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
            otherSystemInput.value = '';

            setManual(
                otherSystemWrapper,
                otherSystemInput,
                false
            );
        }

        loadSubFields(false);
    }

    function loadSubFields(restore = false) {
        const fieldType = fieldTypeSelect.value;
        const selectedSystem = systemChoice.value;

        clearSelect(
            subChoice,
            '-- Pilih Sistem / Sub-Bidang --'
        );

        if (
            fieldType
            && selectedSystem
            && selectedSystem !== '__other__'
        ) {
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

        if (fieldType && selectedSystem) {
            addOtherOption(subChoice);
        }

        if (restore) {
            if (initial.otherSub) {
                subChoice.value = '__other__';
                masterId.value = '';

                setManual(
                    otherSubWrapper,
                    otherSubInput,
                    true
                );
            } else if (initial.masterId) {
                subChoice.value = initial.masterId;
                masterId.value = initial.masterId;

                setManual(
                    otherSubWrapper,
                    otherSubInput,
                    false
                );
            }
        } else {
            subChoice.value = '';
            masterId.value = '';
            otherSubInput.value = '';

            setManual(
                otherSubWrapper,
                otherSubInput,
                false
            );
        }
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
            otherSubInput.value = '';

            setManual(
                otherSubWrapper,
                otherSubInput,
                false
            );
        }
    }

    fieldTypeSelect.addEventListener(
        'change',
        function () {
            loadMainCategories(false);
            loadSystemCategories(false);
            loadSubFields(false);
        }
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
        loadMainCategories(true);
        loadSystemCategories(true);
        loadSubFields(true);
    }
});
</script>

</body>
</html>
