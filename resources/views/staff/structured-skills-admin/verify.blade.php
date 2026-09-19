<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Verify Structured Skill</title>
</head>
<body>

<div style="max-width:900px; margin:0 auto; padding:24px;">
    <h1>Verify / Review Self-Declared Skill</h1>

    <p><strong>Staf:</strong> {{ $staff->display_name }}</p>
    <p><strong>Skill:</strong> {{ $structuredSkill->skill?->name ?? '-' }}</p>

    @php
        $levelLabels = [
            1 => 'Tahap 1 - Asas',
            2 => 'Tahap 2 - Berdikari',
            3 => 'Tahap 3 - Pakar / Rujukan',
        ];
    @endphp

    <p>
        <strong>Self-Declared Level:</strong>
        {{ $levelLabels[$structuredSkill->declared_level] ?? '-' }}
    </p>

    <p>
        <strong>Konteks:</strong><br>
        {{ $structuredSkill->context ?? '-' }}
    </p>

    <p>
        <strong>Bukti:</strong><br>
        {{ $structuredSkill->evidence_type ?? '-' }}
        @if ($structuredSkill->evidence_description)
            — {{ $structuredSkill->evidence_description }}
        @endif
    </p>

    @if ($errors->any())
        <div style="color:#b91c1c;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('staff.structured-skills-admin.verify', [$staff, $structuredSkill]) }}"
    >
        @csrf
        @method('PATCH')

        <div>
            <label for="decision"><strong>Keputusan</strong></label><br>
            <select name="decision" id="decision" required>
                <option value="verified" {{ old('decision', 'verified') === 'verified' ? 'selected' : '' }}>
                    Verified
                </option>
                <option value="rejected" {{ old('decision') === 'rejected' ? 'selected' : '' }}>
                    Ditolak / Tidak Disahkan
                </option>
            </select>
        </div>

        <br>

        <div id="verified-level-wrap">
            <label for="verified_level"><strong>Verified Level</strong></label><br>
            <select name="verified_level" id="verified_level">
                <option value="">-- Pilih Tahap --</option>
                <option value="1" {{ (string) old('verified_level', $structuredSkill->verified_level) === '1' ? 'selected' : '' }}>
                    Tahap 1 - Asas
                </option>
                <option value="2" {{ (string) old('verified_level', $structuredSkill->verified_level) === '2' ? 'selected' : '' }}>
                    Tahap 2 - Berdikari
                </option>
                <option value="3" {{ (string) old('verified_level', $structuredSkill->verified_level) === '3' ? 'selected' : '' }}>
                    Tahap 3 - Pakar / Rujukan
                </option>
            </select>
        </div>

        <br>

        <div>
            <label for="verification_notes"><strong>Verification Notes</strong></label><br>
            <textarea name="verification_notes"
                      id="verification_notes"
                      rows="6"
                      cols="80"
                      required>{{ old('verification_notes', $structuredSkill->verification_notes) }}</textarea>
        </div>

        <br>

        <button type="submit">Simpan Keputusan</button>

        <a href="{{ route('staff.structured-skills-admin.index', $staff) }}" style="margin-left:10px;">
            Batal
        </a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const decision = document.getElementById('decision');
    const verifiedLevel = document.getElementById('verified_level');
    const wrap = document.getElementById('verified-level-wrap');

    function sync() {
        const isVerified = decision.value === 'verified';
        wrap.style.display = isVerified ? 'block' : 'none';
        verifiedLevel.required = isVerified;

        if (!isVerified) {
            verifiedLevel.value = '';
        }
    }

    decision.addEventListener('change', sync);
    sync();
});
</script>

</body>
</html>
