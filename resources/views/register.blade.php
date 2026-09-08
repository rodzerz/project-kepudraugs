<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reģistrācija - ĶepuDraugs.lv</title>
</head>

<body>

    <h1>🐾 ĶepuDraugs.lv</h1>

    <h2>Reģistrācija</h2>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/register">

        @csrf

        <div>
            <label>Vārds</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <br>

        <div>
            <label>E-pasts</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <br>

        <div>
            <label>Parole</label>
            <input type="password" name="password" required>
        </div>

        <br>

        <div>
            <label>Atkārtot paroli</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <br>

        <div>
            <label>Izvēlies lomu</label>

            <select name="role" required>
                <option value="">-- Izvēlies lomu --</option>
                <option value="owner">Mājdzīvnieka īpašnieks</option>
                <option value="sitter">Mājdzīvnieku pieskatītājs</option>
            </select>
        </div>

        <br>

        <button type="submit">Reģistrēties</button>

    </form>

</body>
</html>