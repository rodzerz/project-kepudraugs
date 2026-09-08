<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pievienot mājdzīvnieku - ĶepuDraugs.lv</title>
</head>

<body>

    <h1>🐾 ĶepuDraugs.lv</h1>

    <h2>Pievienot mājdzīvnieku</h2>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/pets">

        @csrf

        <div>
            <label>Vārds</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <br>

        <div>
            <label>Dzīvnieka veids</label>
            <select name="species" required>
                <option value="">-- Izvēlies --</option>
                <option value="Suns">Suns</option>
                <option value="Kaķis">Kaķis</option>
                <option value="Putns">Putns</option>
                <option value="Trusis">Trusis</option>
                <option value="Cits">Cits</option>
            </select>
        </div>

        <br>

        <div>
            <label>Šķirne</label>
            <input type="text" name="breed" value="{{ old('breed') }}">
        </div>

        <br>

        <div>
            <label>Vecums</label>
            <input type="number" name="age" min="0" value="{{ old('age') }}">
        </div>

        <br>

        <div>
            <label>Svars (kg)</label>
            <input type="number" name="weight" step="0.01" min="0" value="{{ old('weight') }}">
        </div>

        <br>

        <div>
            <label>Īpašās prasības</label>
            <br>
            <textarea name="special_requirements" rows="5" cols="40">{{ old('special_requirements') }}</textarea>
        </div>

        <br>

        <button type="submit">Pievienot mājdzīvnieku</button>

    </form>

    <br>

    <a href="/dashboard">Atpakaļ uz paneli</a>

</body>
</html>