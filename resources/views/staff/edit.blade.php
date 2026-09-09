<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staf - {{ $staff->name }}</title>
</head>
<body>

<h1>Edit Maklumat Staf</h1>

<p>
    <a href="{{ route('staff.show', $staff) }}">← Kembali ke Profil Staf</a>
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

<form action="{{ route('staff.update', $staff) }}" method="POST">
    @csrf
    @method('PUT')

    <h2>1. Maklumat Peribadi</h2>

    <div><label>Nama</label><br><input type="text" name="name" value="{{ old('name', $staff->name) }}" required></div><br>
    <div><label>No. KP</label><br><input type="text" name="ic_no" value="{{ old('ic_no', $staff->ic_no) }}" required></div><br>
    <div><label>Gelaran (di pangkal nama)</label><br><input type="text" name="prefix_title" value="{{ old('prefix_title', $staff->prefix_title) }}"></div><br>
    <div><label>Gelaran (di hujung nama)</label><br><input type="text" name="suffix_title" value="{{ old('suffix_title', $staff->suffix_title) }}"></div><br>
    <div><label>Darjah / Bintang / Pingat</label><br><input type="text" name="honours" value="{{ old('honours', $staff->honours) }}"></div><br>

    <div>
        <label>Jantina</label><br>
        <select name="gender">
            <option value="">-- Pilih --</option>
            <option value="Lelaki" {{ old('gender', $staff->gender) === 'Lelaki' ? 'selected' : '' }}>Lelaki</option>
            <option value="Perempuan" {{ old('gender', $staff->gender) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div><br>

    <div><label>Tarikh Lahir</label><br><input type="date" name="date_of_birth" value="{{ old('date_of_birth', $staff->date_of_birth?->format('Y-m-d') ?? $staff->date_of_birth) }}"></div><br>
    <div><label>Warganegara</label><br><input type="text" name="nationality" value="{{ old('nationality', $staff->nationality) }}"></div><br>
    <div><label>Negeri Lahir</label><br><input type="text" name="birth_state" value="{{ old('birth_state', $staff->birth_state) }}"></div><br>
    <div><label>Bangsa</label><br><input type="text" name="race" value="{{ old('race', $staff->race) }}"></div><br>
    <div><label>Agama</label><br><input type="text" name="religion" value="{{ old('religion', $staff->religion) }}"></div><br>
    <div><label>Status Perkahwinan</label><br><input type="text" name="marital_status" value="{{ old('marital_status', $staff->marital_status) }}"></div><br>

    <div>
        <input type="hidden" name="former_police_military" value="0">
        <label><input type="checkbox" name="former_police_military" value="1" {{ old('former_police_military', $staff->former_police_military) ? 'checked' : '' }}> Bekas Polis / Tentera</label>
    </div><br>

    <div><label>Jenis Perumahan</label><br><input type="text" name="housing_type" value="{{ old('housing_type', $staff->housing_type) }}"></div><br>
    <div><label>Pinjaman Perumahan</label><br><input type="text" name="housing_loan" value="{{ old('housing_loan', $staff->housing_loan) }}"></div><br>
    <div><label>Alamat Kediaman</label><br><textarea name="residential_address" rows="3" cols="50">{{ old('residential_address', $staff->residential_address) }}</textarea></div><br>
    <div><label>Bandar</label><br><input type="text" name="city" value="{{ old('city', $staff->city) }}"></div><br>
    <div><label>Poskod</label><br><input type="text" name="postcode" value="{{ old('postcode', $staff->postcode) }}"></div><br>
    <div><label>Negeri</label><br><input type="text" name="state" value="{{ old('state', $staff->state) }}"></div><br>
    <div><label>Tel. Bimbit</label><br><input type="text" name="mobile_phone" value="{{ old('mobile_phone', $staff->mobile_phone) }}"></div><br>
    <div><label>Emel Rasmi</label><br><input type="email" name="official_email" value="{{ old('official_email', $staff->official_email) }}"></div><br>
    <div><label>Emel Peribadi</label><br><input type="email" name="personal_email" value="{{ old('personal_email', $staff->personal_email) }}"></div><br>
    <div><label>Alamat Pejabat</label><br><textarea name="office_address" rows="3" cols="50">{{ old('office_address', $staff->office_address) }}</textarea></div><br>
    <div><label>Blok Pejabat</label><br><input type="text" name="office_block" value="{{ old('office_block', $staff->office_block) }}"></div><br>
    <div><label>Tel. Pejabat</label><br><input type="text" name="office_phone" value="{{ old('office_phone', $staff->office_phone) }}"></div><br>
    <div><label>Fax Pejabat</label><br><input type="text" name="office_fax" value="{{ old('office_fax', $staff->office_fax) }}"></div><br>
    <div><label>KWSP / Pencen</label><br><input type="text" name="retirement_scheme" value="{{ old('retirement_scheme', $staff->retirement_scheme) }}"></div><br>
    <div><label>No. KWSP</label><br><input type="text" name="epf_number" value="{{ old('epf_number', $staff->epf_number) }}"></div><br>
    <div><label>No. Cukai Pendapatan</label><br><input type="text" name="income_tax_number" value="{{ old('income_tax_number', $staff->income_tax_number) }}"></div><br>
    <div><label>Sistem Saraan</label><br><input type="text" name="salary_scheme" value="{{ old('salary_scheme', $staff->salary_scheme) }}"></div><br>
    <div><label>Tarikh Bersara Opsyen</label><br><input type="date" name="optional_retirement_date" value="{{ old('optional_retirement_date', $staff->optional_retirement_date?->format('Y-m-d') ?? $staff->optional_retirement_date) }}"></div><br>
    <div><label>Tahun Bersara Opsyen</label><br><input type="number" name="optional_retirement_year" min="1900" max="2200" value="{{ old('optional_retirement_year', $staff->optional_retirement_year) }}"></div><br>
    <div><label>Opsyen Bersara Wajib</label><br><input type="text" name="mandatory_retirement_option" value="{{ old('mandatory_retirement_option', $staff->mandatory_retirement_option) }}"></div><br>
    <div><label>Tahun Bersara Wajib</label><br><input type="number" name="mandatory_retirement_year" min="1900" max="2200" value="{{ old('mandatory_retirement_year', $staff->mandatory_retirement_year) }}"></div><br>
    <div><label>Tarikh Perisytiharan Harta Terkini</label><br><input type="date" name="latest_property_declaration" value="{{ old('latest_property_declaration', $staff->latest_property_declaration?->format('Y-m-d') ?? $staff->latest_property_declaration) }}"></div><br>
    <div><label>Foto (teks/path sementara)</label><br><input type="text" name="photo" value="{{ old('photo', $staff->photo) }}"></div>

    <hr>
    <h2>2. Maklumat Perkhidmatan</h2>

    <div><label>No. Staf</label><br><input type="text" name="staff_no" value="{{ old('staff_no', $record?->staff_no) }}" required></div><br>
    <div><label>Jurusan</label><br><input type="text" name="field_of_study" value="{{ old('field_of_study', $record?->field_of_study) }}"></div><br>
    <div><label>Kumpulan</label><br><input type="text" name="group" value="{{ old('group', $record?->group) }}"></div><br>
    <div><label>Klasifikasi</label><br><input type="text" name="classification" value="{{ old('classification', $record?->classification) }}"></div><br>
    <div><label>Skim</label><br><input type="text" name="scheme" value="{{ old('scheme', $record?->scheme) }}"></div><br>
    <div><label>Kategori Skim</label><br><input type="text" name="scheme_category" value="{{ old('scheme_category', $record?->scheme_category) }}"></div><br>
    <div><label>Jenis Jawatan</label><br><input type="text" name="appointment_type" value="{{ old('appointment_type', $record?->appointment_type) }}"></div><br>
    <div><label>Jawatan Asas / Lama</label><br><input type="text" name="position" value="{{ old('position', $record?->position) }}"><br><small>Jawatan semasa utama tetap diambil daripada rekod penempatan.</small></div><br>
    <div><label>Gred Asas / Lama</label><br><input type="text" name="grade" value="{{ old('grade', $record?->grade) }}"><br><small>Gred semasa utama tetap diambil daripada rekod penempatan.</small></div><br>

    <div>
        <label>Bahagian</label><br>
        <select name="department_id" id="department_id">
            <option value="">-- Pilih Bahagian --</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}" {{ (string) old('department_id', $record?->department_id) === (string) $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div><br>

    <div>
        <label>Unit</label><br>
        <select name="unit_id" id="unit_id">
            <option value="">-- Pilih Unit --</option>
            @foreach ($units as $unit)
                <option value="{{ $unit->id }}" {{ (string) old('unit_id', $record?->unit_id) === (string) $unit->id ? 'selected' : '' }}>
                    {{ $unit->name }}
                </option>
            @endforeach
        </select>
    </div><br>

    <div><label>Tarikh Mula Berkhidmat</label><br><input type="date" name="service_start_date" value="{{ old('service_start_date', $record?->service_start_date?->format('Y-m-d') ?? $record?->service_start_date) }}"></div><br>
    <div>
        <label>Status Perkhidmatan</label><br>

        <select name="service_status" id="service_status">
            <option value="">-- Pilih Status --</option>

            @foreach ([
                'Aktif',
                'Tidak Aktif',
                'Bersara',
                'Berhenti',
                'Tamat Perkhidmatan'
            ] as $status)
                <option
                    value="{{ $status }}"
                    {{ old('service_status', $record?->service_status) === $status ? 'selected' : '' }}
                >
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div><br>
    <div><label>Tarikh Lantikan</label><br><input type="date" name="appointment_date" value="{{ old('appointment_date', $record?->appointment_date?->format('Y-m-d') ?? $record?->appointment_date) }}"></div><br>
    <div><label>Tarikh Pengesahan</label><br><input type="date" name="confirmation_date" value="{{ old('confirmation_date', $record?->confirmation_date?->format('Y-m-d') ?? $record?->confirmation_date) }}"></div>

    <br><br>
    <button type="submit">Simpan Perubahan</button>
    <a href="{{ route('staff.show', $staff) }}">Batal</a>
</form>

<script>
    const departmentSelect = document.getElementById('department_id');
    const unitSelect = document.getElementById('unit_id');

    if (departmentSelect && unitSelect) {
        departmentSelect.addEventListener('change', async function () {
            const departmentId = this.value;
            unitSelect.innerHTML = '<option value="">-- Pilih Unit --</option>';

            if (!departmentId) return;

            try {
                const response = await fetch(`/departments/${departmentId}/units`);
                if (!response.ok) throw new Error('Gagal mendapatkan senarai unit.');

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
