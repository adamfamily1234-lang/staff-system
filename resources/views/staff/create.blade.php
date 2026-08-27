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

    {{-- Papar error validation --}}
    @if ($errors->any())
        <div>
            <strong>Sila semak maklumat berikut:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <hr>
    @endif


    <form action="{{ route('staff.store') }}" method="POST">

        @csrf


        {{-- ===================================================== --}}
        {{-- 1. MAKLUMAT PERIBADI --}}
        {{-- ===================================================== --}}

        <h2>1. Maklumat Peribadi</h2>


        <div>
            <label>Nama</label><br>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
            >
        </div>

        <br>


        <div>
            <label>No. KP</label><br>
            <input
                type="text"
                name="ic_no"
                value="{{ old('ic_no') }}"
                placeholder="Contoh: 850101-01-1234"
            >
        </div>

        <br>


        <div>
            <label>Gelaran (di pangkal nama)</label><br>
            <input
                type="text"
                name="prefix_title"
                value="{{ old('prefix_title') }}"
                placeholder="Contoh: Ir., Dr."
            >
        </div>

        <br>


        <div>
            <label>Gelaran (di hujung nama)</label><br>
            <input
                type="text"
                name="suffix_title"
                value="{{ old('suffix_title') }}"
                placeholder="Contoh: J.P., P.I.S."
            >
        </div>

        <br>


        <div>
            <label>Darjah / Bintang / Pingat</label><br>
            <input
                type="text"
                name="honours"
                value="{{ old('honours') }}"
            >
        </div>

        <br>


        <div>
            <label>Jantina</label><br>

            <select name="gender">
                <option value="">-- Pilih Jantina --</option>

                <option
                    value="Lelaki"
                    @selected(old('gender') == 'Lelaki')
                >
                    Lelaki
                </option>

                <option
                    value="Perempuan"
                    @selected(old('gender') == 'Perempuan')
                >
                    Perempuan
                </option>
            </select>
        </div>

        <br>


        <div>
            <label>Tarikh Lahir</label><br>
            <input
                type="date"
                name="date_of_birth"
                value="{{ old('date_of_birth') }}"
            >
        </div>

        <br>


        <div>
            <label>Warganegara</label><br>
            <input
                type="text"
                name="nationality"
                value="{{ old('nationality', 'Malaysia') }}"
            >
        </div>

        <br>


        <div>
            <label>Negeri Lahir</label><br>
            <input
                type="text"
                name="birth_state"
                value="{{ old('birth_state') }}"
            >
        </div>

        <br>


        <div>
            <label>Bangsa</label><br>
            <input
                type="text"
                name="race"
                value="{{ old('race') }}"
            >
        </div>

        <br>


        <div>
            <label>Agama</label><br>
            <input
                type="text"
                name="religion"
                value="{{ old('religion') }}"
            >
        </div>

        <br>


        <div>
            <label>Status Perkahwinan</label><br>

            <select name="marital_status">

                <option value="">
                    -- Pilih Status --
                </option>

                <option
                    value="Bujang"
                    @selected(old('marital_status') == 'Bujang')
                >
                    Bujang
                </option>

                <option
                    value="Berkahwin"
                    @selected(old('marital_status') == 'Berkahwin')
                >
                    Berkahwin
                </option>

                <option
                    value="Duda"
                    @selected(old('marital_status') == 'Duda')
                >
                    Duda
                </option>

                <option
                    value="Janda"
                    @selected(old('marital_status') == 'Janda')
                >
                    Janda
                </option>

            </select>
        </div>

        <br>


        <div>

            <label>

                <input
                    type="checkbox"
                    name="former_police_military"
                    value="1"
                    @checked(old('former_police_military'))
                >

                Bekas Polis / Tentera

            </label>

        </div>

        <br>


        <div>
            <label>Jenis Perumahan</label><br>
            <input
                type="text"
                name="housing_type"
                value="{{ old('housing_type') }}"
                placeholder="Contoh: Rumah Kerajaan / Rumah Sendiri"
            >
        </div>

        <br>


        <div>
            <label>Pinjaman Perumahan</label><br>
            <input
                type="text"
                name="housing_loan"
                value="{{ old('housing_loan') }}"
                placeholder="Contoh: Ada / Tiada"
            >
        </div>

        <br>


        <div>
            <label>Alamat Kediaman</label><br>

            <textarea
                name="residential_address"
                rows="3"
                cols="50"
            >{{ old('residential_address') }}</textarea>
        </div>

        <br>


        <div>
            <label>Bandar</label><br>

            <input
                type="text"
                name="city"
                value="{{ old('city') }}"
            >
        </div>

        <br>


        <div>
            <label>Poskod</label><br>

            <input
                type="text"
                name="postcode"
                value="{{ old('postcode') }}"
            >
        </div>

        <br>


        <div>
            <label>Negeri</label><br>

            <input
                type="text"
                name="state"
                value="{{ old('state') }}"
            >
        </div>

        <br>


        <div>
            <label>Tel. Bimbit</label><br>

            <input
                type="text"
                name="mobile_phone"
                value="{{ old('mobile_phone') }}"
            >
        </div>

        <br>


        <div>
            <label>Emel Rasmi</label><br>

            <input
                type="email"
                name="official_email"
                value="{{ old('official_email') }}"
            >
        </div>

        <br>


        <div>
            <label>Emel Peribadi</label><br>

            <input
                type="email"
                name="personal_email"
                value="{{ old('personal_email') }}"
            >
        </div>

        <br>


        <div>
            <label>Alamat Pejabat</label><br>

            <textarea
                name="office_address"
                rows="3"
                cols="50"
            >{{ old('office_address') }}</textarea>
        </div>

        <br>


        <div>
            <label>Blok Pejabat</label><br>

            <input
                type="text"
                name="office_block"
                value="{{ old('office_block') }}"
            >
        </div>

        <br>


        <div>
            <label>Tel. Pejabat</label><br>

            <input
                type="text"
                name="office_phone"
                value="{{ old('office_phone') }}"
            >
        </div>

        <br>


        <div>
            <label>Fax. Pejabat</label><br>

            <input
                type="text"
                name="office_fax"
                value="{{ old('office_fax') }}"
            >
        </div>

        <br>


        <div>
            <label>KWSP atau Pencen</label><br>

            <select name="retirement_scheme">

                <option value="">
                    -- Pilih --
                </option>

                <option
                    value="KWSP"
                    @selected(old('retirement_scheme') == 'KWSP')
                >
                    KWSP
                </option>

                <option
                    value="Pencen"
                    @selected(old('retirement_scheme') == 'Pencen')
                >
                    Pencen
                </option>

            </select>
        </div>

        <br>


        <div>
            <label>No. KWSP</label><br>

            <input
                type="text"
                name="epf_number"
                value="{{ old('epf_number') }}"
            >
        </div>

        <br>


        <div>
            <label>No. Cukai Pendapatan</label><br>

            <input
                type="text"
                name="income_tax_number"
                value="{{ old('income_tax_number') }}"
            >
        </div>

        <br>


        <div>
            <label>Sistem Saraan</label><br>

            <input
                type="text"
                name="salary_scheme"
                value="{{ old('salary_scheme') }}"
                placeholder="Contoh: SSPA"
            >
        </div>

        <br>


        <div>
            <label>Tarikh Bersara Opsyen</label><br>

            <input
                type="date"
                name="optional_retirement_date"
                value="{{ old('optional_retirement_date') }}"
            >
        </div>

        <br>


        <div>
            <label>Tahun Bersara Opsyen</label><br>

            <input
                type="number"
                name="optional_retirement_year"
                value="{{ old('optional_retirement_year') }}"
                min="1900"
                max="2200"
            >
        </div>

        <br>


        <div>
            <label>Pilihan Bersara Wajib</label><br>

            <input
                type="text"
                name="mandatory_retirement_option"
                value="{{ old('mandatory_retirement_option') }}"
            >
        </div>

        <br>


        <div>
            <label>Tahun Bersara Wajib</label><br>

            <input
                type="number"
                name="mandatory_retirement_year"
                value="{{ old('mandatory_retirement_year') }}"
                min="1900"
                max="2200"
            >
        </div>

        <br>


        <div>
            <label>Pengisytiharan Harta Terkini</label><br>

            <input
                type="date"
                name="latest_property_declaration"
                value="{{ old('latest_property_declaration') }}"
            >
        </div>

        <br>


        <div>
            <label>Gambar</label><br>

            <input
                type="text"
                name="photo"
                value="{{ old('photo') }}"
                placeholder="Nama fail gambar (sementara)"
            >
        </div>


        <hr>


        {{-- ===================================================== --}}
        {{-- 2. MAKLUMAT PERKHIDMATAN --}}
        {{-- ===================================================== --}}

        <h2>2. Maklumat Perkhidmatan</h2>


        <div>
            <label>No. Staf</label><br>

            <input
                type="text"
                name="staff_no"
                value="{{ old('staff_no') }}"
            >
        </div>

        <br>


        <div>
            <label>Jurusan</label><br>

            <input
                type="text"
                name="field_of_study"
                value="{{ old('field_of_study') }}"
            >
        </div>

        <br>


        <div>
            <label>Kumpulan</label><br>

            <input
                type="text"
                name="group"
                value="{{ old('group') }}"
            >
        </div>

        <br>


        <div>
            <label>Klasifikasi</label><br>

            <input
                type="text"
                name="classification"
                value="{{ old('classification') }}"
            >
        </div>

        <br>


        <div>
            <label>Skim</label><br>

            <input
                type="text"
                name="scheme"
                value="{{ old('scheme') }}"
            >
        </div>

        <br>


        <div>
            <label>Kategori Skim</label><br>

            <input
                type="text"
                name="scheme_category"
                value="{{ old('scheme_category') }}"
            >
        </div>

        <br>


        <div>
            <label>Jenis Jawatan</label><br>

            <input
                type="text"
                name="appointment_type"
                value="{{ old('appointment_type') }}"
            >
        </div>

        <br>


        <div>
            <label>Jawatan</label><br>

            <input
                type="text"
                name="position"
                value="{{ old('position') }}"
            >
        </div>

        <br>


        <div>
            <label>Gred</label><br>

            <input
                type="text"
                name="grade"
                value="{{ old('grade') }}"
            >
        </div>

        <br>


        <div>
            <label>Bahagian</label><br>

            <select name="department_id" id="department_id">

                <option value="">
                    -- Pilih Bahagian --
                </option>

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

                <option value="">
                    -- Pilih Unit --
                </option>

            </select>

        </div>

        <br>


        <div>
            <label>Tarikh Mula Berkhidmat</label><br>

            <input
                type="date"
                name="service_start_date"
                value="{{ old('service_start_date') }}"
            >
        </div>

        <br>


        <div>
            <label>Status Perkhidmatan</label><br>

            <input
                type="text"
                name="service_status"
                value="{{ old('service_status') }}"
                placeholder="Contoh: Aktif"
            >
        </div>

        <br>


        <div>
            <label>Tarikh Lantikan</label><br>

            <input
                type="date"
                name="appointment_date"
                value="{{ old('appointment_date') }}"
            >
        </div>

        <br>


        <div>
            <label>Tarikh Pengesahan</label><br>

            <input
                type="date"
                name="confirmation_date"
                value="{{ old('confirmation_date') }}"
            >
        </div>

        <br>


        {{-- ===================================================== --}}
        {{-- SIMPAN --}}
        {{-- ===================================================== --}}

        <button type="submit">
            Simpan Staf
        </button>

    </form>


    {{-- ===================================================== --}}
    {{-- JAVASCRIPT: BAHAGIAN → UNIT --}}
    {{-- ===================================================== --}}

    <script>

        const departmentSelect =
            document.getElementById('department_id');

        const unitSelect =
            document.getElementById('unit_id');


        departmentSelect.addEventListener('change', function () {

            const departmentId = this.value;

            unitSelect.innerHTML =
                '<option value="">-- Pilih Unit --</option>';


            if (!departmentId) {
                return;
            }


            fetch(`/departments/${departmentId}/units`)

                .then(response => {

                    if (!response.ok) {
                        throw new Error('Gagal mendapatkan data unit.');
                    }

                    return response.json();

                })

                .then(units => {

                    units.forEach(unit => {

                        const option =
                            document.createElement('option');

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