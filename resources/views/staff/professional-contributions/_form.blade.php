@php($item = $professionalContribution ?? null)

@if ($errors->any())
    <div style="color:#b91c1c;">
        <ul>
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<label>Jenis Penglibatan</label><br>
<select name="activity_type">
    <option value="">-- Pilih --</option>
    @foreach ([
        'Jawatankuasa / Panel',
        'Pembentangan / Penceramah',
        'Penulisan / Penerbitan',
        'Penilai / Auditor / Pemeriksa',
        'Mentor / Coach',
        'Khidmat Nasihat / Perundingan',
        'Penyelidikan / Inovasi',
        'Persatuan / Badan Profesional',
        'Program Komuniti / CSR',
        'Lain-lain'
    ] as $type)
        <option value="{{ $type }}" {{ old('activity_type', $item?->activity_type) === $type ? 'selected' : '' }}>
            {{ $type }}
        </option>
    @endforeach
</select>

<br><br>
<label>Nama Aktiviti / Sumbangan</label><br>
<input type="text" name="activity_name" value="{{ old('activity_name', $item?->activity_name) }}" required style="width:500px;">

<br><br>
<label>Peranan</label><br>
<input type="text" name="role" value="{{ old('role', $item?->role) }}" style="width:500px;">

<br><br>
<label>Organisasi / Badan</label><br>
<input type="text" name="organization" value="{{ old('organization', $item?->organization) }}" style="width:500px;">

<br><br>
<label>Peringkat</label><br>
<select name="level">
    <option value="">-- Pilih --</option>
    @foreach (['Jabatan','Negeri','Kebangsaan','Antarabangsa','Lain-lain'] as $level)
        <option value="{{ $level }}" {{ old('level', $item?->level) === $level ? 'selected' : '' }}>{{ $level }}</option>
    @endforeach
</select>

<br><br>
<label>Tarikh Mula</label><br>
<input type="date" name="start_date" value="{{ old('start_date', $item?->start_date?->format('Y-m-d')) }}">

<br><br>
<label>Tarikh Tamat</label><br>
<input type="date" name="end_date" value="{{ old('end_date', $item?->end_date?->format('Y-m-d')) }}">
<br><small>Biarkan kosong jika masih aktif / berterusan.</small>

<br><br>
<label>No. Rujukan / No. Sijil</label><br>
<input type="text" name="reference_no" value="{{ old('reference_no', $item?->reference_no) }}" style="width:350px;">

<br><br>
<label>Catatan</label><br>
<textarea name="notes" rows="4" cols="70">{{ old('notes', $item?->notes) }}</textarea>
