<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Izveidot pieskatītāja profilu - ĶepuDraugs.lv</title>
</head>

<body>

    <h1>🐾 ĶepuDraugs.lv</h1>

    <h2>Izveidot pieskatītāja profilu</h2>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/sitter-profile">

        @csrf

        <div>
            <label>Pilsēta</label>
            <input type="text" name="city" value="{{ old('city') }}" required>
        </div>

        <br>

        <div>
            <label>Par sevi</label>
            <br>
            <textarea name="description" rows="5" cols="40">{{ old('description') }}</textarea>
        </div>

        <br>

        <div>
            <label>Pieredze</label>
            <br>
            <textarea name="experience" rows="5" cols="40">{{ old('experience') }}</textarea>
        </div>

        <br>

        <div>
            <label>Cena par dienu (€)</label>
            <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
        </div>

        <br>

        <div>
            <label>Kādus dzīvniekus pieskati?</label>
            <br>
            <input type="text" name="accepted_animals" value="{{ old('accepted_animals') }}" placeholder="Piemēram: suņi, kaķi" required>
        </div>

        <br>

        <button type="submit">Saglabāt profilu</button>

    </form>

    <br>

    <a href="/dashboard">Atpakaļ uz paneli</a>

</body>
</html>