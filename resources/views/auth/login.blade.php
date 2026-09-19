<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk - Staff System</title>
</head>
<body>
<div style="max-width:420px; margin:60px auto; padding:24px; border:1px solid #ddd;">
    <h1>Log Masuk</h1>
    <p>Sistem Pengurusan Data Staf</p>

    @if ($errors->any())
        <div style="color:#b91c1c; margin-bottom:16px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <label for="email"><strong>Emel</strong></label><br>
        <input type="email" name="email" id="email"
               value="{{ old('email') }}" required autofocus
               autocomplete="username"
               style="width:100%; padding:8px; box-sizing:border-box;">

        <br><br>

        <label for="password"><strong>Kata Laluan</strong></label><br>
        <input type="password" name="password" id="password"
               required autocomplete="current-password"
               style="width:100%; padding:8px; box-sizing:border-box;">

        <br><br>

        <label>
            <input type="checkbox" name="remember" value="1">
            Ingat saya
        </label>

        <br><br>

        <button type="submit">Log Masuk</button>
    </form>
</div>
</body>
</html>
