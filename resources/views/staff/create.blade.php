<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Staf</title>
</head>

<body>

    <h1>Tambah Staf</h1>

    <a href="{{ route('staff.index') }}">
        ← Kembali ke Senarai Staf
    </a>

    <hr>

    <form action="{{ route('staff.store') }}" method="POST">
        @csrf

        <h2>1. Maklumat Peribadi</h2>

        <div>
            <label>Nama</label><br>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <br>

        <div>
            <label>No. KP</label><br>
            <input type="text" name="ic_no" value="{{ old('ic_no') }}">
        </div>

        <br>

        <div>
            <label>Gelaran (di pangkal nama)</label><br>
            <input type="text" name="prefix_title" value="{{ old('prefix_title') }}">
        </div>

        <br>

        <div>
            <label>Gelaran (di hujung nama)</label><br>
            <input type="text" name="suffix_title" value="{{ old('suffix_title') }}">
        </div>

        <br>

        <div>
            <label>Jantina</label><br>

            <select name="gender">
                <option value="">-- Pilih Jantina --</option>
                <option value="Lelaki">Lelaki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <br>

        <div>
            <label>Tarikh Lahir</label><br>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
        </div>

        <br>

        <div>
            <label>Warganegara</label><br>
            <input type="text" name="nationality" value="{{ old('nationality', 'Malaysia') }}">
        </div>

        <br>

        <div>
            <label>Negeri Lahir</label><br>
            <input type="text" name="birth_state" value="{{ old('birth_state') }}">
        </div>

        <br>

        <div>
            <label>Bangsa</label><br>
            <input type="text" name="race" value="{{ old('race') }}">
        </div>

        <br>

        <div>
            <label>Agama</label><br>
            <input type="text" name="religion" value="{{ old('religion') }}">
        </div>

        <br>

        <div>
            <label>Status Perkahwinan</label><br>

            <select name="marital_status">
                <option value="">-- Pilih Status --</option>
                <option value="Bujang">Bujang</option>
                <option value="Berkahwin">Berkahwin</option>
                <option value="Duda">Duda</option>
                <option value="Janda">Janda</option>
            </select>
        </div>

        <br>

        <div>
            <label>
                <input
                    type="checkbox"
                    name="former_police_military"
                    value="1"
                >
                Bekas Polis / Tentera
            </label>
        </div>

        <br>
<hr>

<h2>2. Maklumat Perkhidmatan</h2>

<div>
    <label>No. Staf</label><br>
    <input type="text" name="staff_no" value="{{ old('staff_no') }}">
</div>

<br>

<div>
    <label>Jurusan</label><br>
    <input type="text" name="field_of_study" value="{{ old('field_of_study') }}">
</div>

<br>

<div>
    <label>Kumpulan</label><br>
    <input type="text" name="group" value="{{ old('group') }}">
</div>

<br>

<div>
    <label>Klasifikasi</label><br>
    <input type="text" name="classification" value="{{ old('classification') }}">
</div>

<br>

<div>
    <label>Skim</label><br>
    <input type="text" name="scheme" value="{{ old('scheme') }}">
</div>

<br>

<div>
    <label>Kategori Skim</label><br>
    <input type="text" name="scheme_category" value="{{ old('scheme_category') }}">
</div>

<br>

<div>
    <label>Jenis Jawatan</label><br>
    <input type="text" name="appointment_type" value="{{ old('appointment_type') }}">
</div>

<br>

<div>
    <label>Jawatan</label><br>
    <input type="text" name="position" value="{{ old('position') }}">
</div>

<br>

<div>
    <label>Gred</label><br>
    <input type="text" name="grade" value="{{ old('grade') }}">
</div>
<br>

<div>
    <label>Bahagian</label><br>

    <select name="department_id" id="department_id">
        <option value="">-- Pilih Bahagian --</option>

        @foreach ($departments as $department)
            <option
                value="{{ $department->id }}"
                @selected(old('department_id') == $department->id)
            >
                {{ $department->name }}
            </option>
        @endforeach

    </select>
</div>

<br>

<div>
    <label>Unit</label><br>

    <select name="unit_id" id="unit_id">
    <option value="">-- Pilih Unit --</option>
</select>

</div>

<br>

<div>
    <label>Tarikh Mula Berkhidmat</label><br>
    <input type="date" name="service_start_date"
           value="{{ old('service_start_date') }}">
</div>

<br>

<div>
    <label>Status Perkhidmatan</label><br>
    <input type="text" name="service_status"
           value="{{ old('service_status') }}">
</div>

<br>

<div>
    <label>Tarikh Lantikan</label><br>
    <input type="date" name="appointment_date"
           value="{{ old('appointment_date') }}">
</div>

<br>

<div>
    <label>Tarikh Pengesahan</label><br>
    <input type="date" name="confirmation_date"
           value="{{ old('confirmation_date') }}">
</div>

<br>
        <button type="submit">
            Simpan Staf
        </button>

    </form>
<script>
    const departmentSelect = document.getElementById('department_id');
    const unitSelect = document.getElementById('unit_id');

    departmentSelect.addEventListener('change', function () {
        const departmentId = this.value;

        unitSelect.innerHTML =
            '<option value="">-- Pilih Unit --</option>';

        if (!departmentId) {
            return;
        }

        fetch(`/departments/${departmentId}/units`)
            .then(response => response.json())
            .then(units => {
                units.forEach(unit => {
                    const option = document.createElement('option');

                    option.value = unit.id;
                    option.textContent = unit.name;

                    unitSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
</body>
</html>