```blade
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Īpašnieka panelis - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-owner-nav />

    <main class="page-container">

        <div class="card">

            <p class="subtitle">🐾 ĶepuDraugs.lv</p>

            <h1 class="page-title">
                Sveiks, {{ auth()->user()->name }}!
            </h1>

            <p class="page-description">
                Šeit vari pārvaldīt savus mājdzīvniekus, atrast piemērotu
                pieskatītāju un apskatīt savas rezervācijas.
            </p>

        </div>

        <div class="features">

            <div class="feature">
                <div class="feature-icon">🐶</div>

                <h3>Mani mājdzīvnieki</h3>

                <p>
                    Pievieno un pārvaldi informāciju par saviem
                    mājdzīvniekiem.
                </p>

                <a href="/pets" class="main-button">
                    Apskatīt
                </a>
            </div>

            <div class="feature">
                <div class="feature-icon">🐾</div>

                <h3>Pieskatītāji</h3>

                <p>
                    Atrodi piemērotu mājdzīvnieku pieskatītāju
                    pēc pilsētas.
                </p>

                <a href="/sitters" class="main-button">
                    Meklēt
                </a>
            </div>

            <div class="feature">
                <div class="feature-icon">📅</div>

                <h3>Manas rezervācijas</h3>

                <p>
                    Apskati savus rezervāciju pieprasījumus
                    un to statusus.
                </p>

                <a href="/bookings" class="main-button">
                    Apskatīt
                </a>
            </div>

        </div>

    </main>

</body>
</html>
```
