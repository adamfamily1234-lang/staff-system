<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penempatan</title>
</head>
<body>
<h1>Edit Rekod Penempatan / Sejarah Perkhidmatan</h1>
<p><a href="{{ route('staff.show', $staff) }}">← Kembali ke Profil Staf</a></p>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('staff.placements.update', [$staff, $placement]) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Gred</label><br>
    <select name="grade_master_id" required>
        @foreach ($gradeMasters as $grade)
            <option value="{{ $grade->id }}"
                {{ (string) old('grade_master_id', $placement->grade_master_id) === (string) $grade->id ? 'selected' : '' }}>
                {{ $grade->grade_code }} - {{ $grade->grade_category }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Status Gred</label><br>
    <select name="grade_status" required>
        @foreach (['Hakiki','Memangku'] as $status)
            <option value="{{ $status }}"
                {{ old('grade_status', $placement->grade_status) === $status ? 'selected' : '' }}>
                {{ $status }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Jawatan</label><br>
    <select name="position_master_id">
        <option value="">-- Pilih Jawatan --</option>
        @foreach ($positionMasters as $position)
            <option value="{{ $position->id }}"
                {{ (string) old('position_master_id', $placement->position_master_id) === (string) $position->id ? 'selected' : '' }}>
                {{ $position->name }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Jenis Penempatan</label><br>
    <select name="placement_type_master_id">
        <option value="">-- Pilih Jenis Penempatan --</option>
        @foreach ($placementTypeMasters as $item)
            <option value="{{ $item->id }}"
                {{ (string) old('placement_type_master_id', $placement->placement_type_master_id) === (string) $item->id ? 'selected' : '' }}>
                {{ $item->name }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Bahagian</label><br>
    <select name="department_id" id="placement_edit_department_id">
        <option value="">-- Pilih Bahagian --</option>
        @foreach ($departments as $department)
            <option value="{{ $department->id }}"
                {{ (string) old('department_id', $placement->department_id) === (string) $department->id ? 'selected' : '' }}>
                {{ $department->name }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Unit</label><br>
    <select name="unit_id" id="placement_edit_unit_id">
        <option value="">-- Pilih Unit --</option>
        @foreach ($units as $unit)
            <option value="{{ $unit->id }}"
                {{ (string) old('unit_id', $placement->unit_id) === (string) $unit->id ? 'selected' : '' }}>
                {{ $unit->name }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Tarikh Mula</label><br>
    <input type="date" name="start_date"
           value="{{ old('start_date', $placement->start_date?->format('Y-m-d') ?? $placement->start_date) }}"
           required>
    <br><br>

    <p>
        <strong>Tarikh Tamat:</strong>
        sistem akan kira semula secara automatik berdasarkan rekod penempatan berikutnya.
    </p>

    <label>Catatan</label><br>
    <textarea name="notes" rows="4" cols="50">{{ old('notes', $placement->notes) }}</textarea>
    <br><br>

    <button type="submit">Simpan Perubahan</button>
</form>

<script>
    const departmentSelect = document.getElementById('placement_edit_department_id');
    const unitSelect = document.getElementById('placement_edit_unit_id');

    if (departmentSelect && unitSelect) {
        departmentSelect.addEventListener('change', async function () {
            const departmentId = this.value;

            unitSelect.innerHTML =
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
                    unitSelect.appendChild(option);
                });
            } catch (error) {
                console.error(error);
                alert('Tidak dapat memuatkan senarai unit.');
            }
        });
    }
</script>
</body>
</html>
