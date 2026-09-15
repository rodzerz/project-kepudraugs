```blade
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pieskatītāja panelis - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-sitter-nav />

    <main class="page-container">

        <div class="card">

            <p class="subtitle">🐾 ĶepuDraugs.lv</p>

            <h1 class="page-title">
                Sveiks, {{ auth()->user()->name }}!
            </h1>

            <p class="page-description">
                Šeit vari pārvaldīt savu pieskatītāja profilu,
                apskatīt saņemtās rezervācijas un sazināties ar
                mājdzīvnieku īpašniekiem.
            </p>

        </div>

        <div class="features">

            <div class="feature">
                <div class="feature-icon">👤</div>

                <h3>Mans profils</h3>

                <p>
                    Apskati un rediģē savu lietotāja profilu.
                </p>

                <a href="/profile" class="main-button">
                    Apskatīt
                </a>
            </div>

            <div class="feature">
                <div class="feature-icon">📅</div>

                <h3>Saņemtās rezervācijas</h3>

                <p>
                    Apskati rezervāciju pieprasījumus un
                    pārvaldi to statusus.
                </p>

                <a href="/bookings/sitter" class="main-button">
                    Apskatīt
                </a>
            </div>

            <div class="feature">
                <div class="feature-icon">🐕</div>

                <h3>Pieskatīšanas pakalpojumi</h3>

                <p>
                    Piedāvā mājdzīvnieku īpašniekiem savus
                    pieskatīšanas pakalpojumus.
                </p>

                <a href="/sitter-profile" class="main-button">
                    Mans profils
                </a>
            </div>

        </div>

    </main>

</body>
</html>
```
