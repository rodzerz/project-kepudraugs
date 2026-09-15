```blade
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Izveidot pieskatītāja profilu - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-sitter-nav />

    <main class="page-container">

        <div class="form-container">

            <div class="card">

                <div style="text-align: center;">

                    <div class="feature-icon">
                        🐕
                    </div>

                    <p class="subtitle">
                        🐾 Kļūsti par pieskatītāju
                    </p>

                    <h1 class="page-title">
                        Izveidot pieskatītāja profilu
                    </h1>

                    <p class="page-description">
                        Norādi informāciju par sevi un saviem
                        piedāvātajiem mājdzīvnieku pieskatīšanas pakalpojumiem.
                    </p>

                </div>

                @if ($errors->any())

                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>

                @endif

                <form action="/sitter-profile" method="POST">

                    @csrf

                    <div class="form-group">

                        <label for="city">
                            📍 Pilsēta
                        </label>

                        <input
                            type="text"
                            id="city"
                            name="city"
                            value="{{ old('city') }}"
                            placeholder="Piemēram, Rīga"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="description">
                            💬 Par sevi
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            placeholder="Pastāsti nedaudz par sevi..."
                        >{{ old('description') }}</textarea>

                    </div>

                    <div class="form-group">

                        <label for="experience">
                            ⭐ Pieredze
                        </label>

                        <textarea
                            id="experience"
                            name="experience"
                            placeholder="Apraksti savu pieredzi darbā ar mājdzīvniekiem..."
                        >{{ old('experience') }}</textarea>

                    </div>

                    <div class="form-group">

                        <label for="price">
                            💶 Cena (€ / dienā)
                        </label>

                        <input
                            type="number"
                            id="price"
                            name="price"
                            value="{{ old('price') }}"
                            min="0"
                            step="0.01"
                            placeholder="Piemēram, 15.00"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="accepted_animals">
                            🐾 Pieskatāmie dzīvnieki
                        </label>

                        <input
                            type="text"
                            id="accepted_animals"
                            name="accepted_animals"
                            value="{{ old('accepted_animals') }}"
                            placeholder="Piemēram, Suņi, kaķi, truši"
                            required
                        >

                    </div>

                    <button type="submit">
                        ✓ Izveidot profilu
                    </button>

                </form>

            </div>

        </div>

    </main>

</body>
</html>
```
