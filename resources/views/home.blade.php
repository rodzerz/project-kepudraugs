<!DOCTYPE html>

<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>ĶepuDraugs.lv</title>

<link rel="stylesheet" href="{{ asset('css/style.css') }}">


</head>

<body>


<header class="header">
    <div class="header-content">

        <a href="/" class="logo">
            🐾 ĶepuDraugs.lv
        </a>

    </div>
</header>


<main>

    <section class="hero">

        <div class="hero-text">

            <p class="subtitle">🐾 Uzticama aprūpe Tavam mīlulim</p>

            <h1>
                Atrodi savu<br>
                <span>ĶepuDraugu</span>
            </h1>

            <p class="hero-description">
                ĶepuDraugs.lv palīdz mājdzīvnieku īpašniekiem
                atrast uzticamus pieskatītājus saviem mīluļiem.
            </p>

            <div class="hero-buttons">
                <a href="/register" class="main-button">
                    Sākt izmantot
                </a>

                <a href="/login" class="secondary-button">
                    Pieslēgties
                </a>
            </div>

        </div>

        <div class="hero-paw">
            🐶
        </div>

    </section>


    <section class="about">

        <h2>Par ĶepuDraugs.lv</h2>

        <p>
            Mūsu mērķis ir padarīt mājdzīvnieku pieskatītāja
            atrašanu vienkāršāku, ērtāku un pārskatāmāku.
        </p>

        <div class="features">

            <div class="feature">
                <div class="feature-icon">🔎</div>

                <h3>Atrodi pieskatītāju</h3>

                <p>
                    Meklē piemērotu pieskatītāju pēc savām vajadzībām.
                </p>
            </div>


            <div class="feature">
                <div class="feature-icon">❤️</div>

                <h3>Izvēlies uzticamu</h3>

                <p>
                    Apskati informāciju, pieredzi un atsauksmes.
                </p>
            </div>


            <div class="feature">
                <div class="feature-icon">📅</div>

                <h3>Veic rezervāciju</h3>

                <p>
                    Ērti vienojies par mājdzīvnieka pieskatīšanu.
                </p>
            </div>

        </div>

    </section>

</main>


<footer>
    <p>© {{ date('Y') }} ĶepuDraugs.lv</p>
</footer>
```

</body>
</html>
