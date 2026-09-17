


<div style="max-width:1100px; margin:0 auto; padding:24px;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:20px;">
        <div>
            <h1 style="margin:0;">Tambah Kurniaan / Gelaran Kehormat</h1>
            <div style="margin-top:6px;">Pegawai: <strong>{{ $staff->name }}</strong></div>
        </div>

        <a href="{{ route('staff.show', $staff) }}">← Kembali ke Profil</a>
    </div>

    <form method="POST" action="{{ route('staff.honorary-titles.store', $staff) }}">
        @csrf

        @include('staff.honorary-titles._form')

        <div style="margin-top:20px;">
            <button type="submit" style="padding:10px 18px;">
                Simpan Kurniaan
            </button>
        </div>
    </form>
</div>


