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

        <!-- SVEICIENA BLOKS -->

        <section class="dashboard-hero">

            <div class="dashboard-hero-content">

                <p class="section-label">
                    Pieskatītāja panelis
                </p>

                <h1>
                    Sveiks, {{ auth()->user()->name }}!
                </h1>

                <p>
                    Pārvaldi savu pieskatītāja profilu, apskati
                    saņemtās rezervācijas un sazinies ar
                    mājdzīvnieku īpašniekiem vienuviet.
                </p>

                <div class="dashboard-hero-actions">

                    <a
                        href="/bookings/sitter"
                        class="main-button"
                    >
                        📅 Saņemtās rezervācijas
                    </a>

                    <a
                        href="/sitter-profile"
                        class="secondary-button"
                    >
                        Mans pieskatītāja profils
                    </a>

                </div>

            </div>


            <div class="dashboard-hero-visual">

                <div class="dashboard-paw">
                    🐾
                </div>

                <span>
                    ĶepuDraugs.lv
                </span>

            </div>

        </section>


        <!-- ĀTRĀS DARBĪBAS -->

        <section class="dashboard-section">

            <div class="dashboard-section-heading">

                <div>

                    <p class="section-label">
                        Ātrās darbības
                    </p>

                    <h2>
                        Ko vēlies darīt?
                    </h2>

                </div>

            </div>


            <div class="dashboard-actions-grid">

                <!-- LIETOTĀJA PROFILS -->

                <article class="dashboard-action-card">

                    <div class="dashboard-action-icon">
                        👤
                    </div>

                    <div class="dashboard-action-content">

                        <h3>
                            Mans profils
                        </h3>

                        <p>
                            Apskati un rediģē sava ĶepuDraugs.lv
                            konta pamatinformāciju.
                        </p>

                    </div>

                    <a
                        href="/profile"
                        class="dashboard-card-link"
                    >
                        Apskatīt profilu
                        <span>→</span>
                    </a>

                </article>


                <!-- REZERVĀCIJAS -->

                <article class="dashboard-action-card">

                    <div class="dashboard-action-icon">
                        📅
                    </div>

                    <div class="dashboard-action-content">

                        <h3>
                            Saņemtās rezervācijas
                        </h3>

                        <p>
                            Apskati mājdzīvnieku īpašnieku
                            rezervāciju pieprasījumus un pārvaldi to statusus.
                        </p>

                    </div>

                    <a
                        href="/bookings/sitter"
                        class="dashboard-card-link"
                    >
                        Skatīt rezervācijas
                        <span>→</span>
                    </a>

                </article>


                <!-- PIESKATĪTĀJA PROFILS -->

                <article class="dashboard-action-card">

                    <div class="dashboard-action-icon">
                        🐕
                    </div>

                    <div class="dashboard-action-content">

                        <h3>
                            Pieskatītāja profils
                        </h3>

                        <p>
                            Pārvaldi savu aprakstu, pieredzi,
                            cenu un pieskatāmo dzīvnieku informāciju.
                        </p>

                    </div>

                    <a
                        href="/sitter-profile"
                        class="dashboard-card-link"
                    >
                        Atvērt profilu
                        <span>→</span>
                    </a>

                </article>

            </div>

        </section>


        <!-- INFORMĀCIJAS BLOKS -->

        <section class="dashboard-info-card">

            <div class="dashboard-info-icon">
                💡
            </div>

            <div>

                <h3>
                    Uzturi savu profilu aktuālu
                </h3>

                <p>
                    Pārliecinies, ka tavā pieskatītāja profilā ir
                    norādīta aktuāla pilsēta, pieredze, cena un
                    mājdzīvnieki, kurus esi gatavs pieskatīt.
                </p>

            </div>

            <a
                href="/sitter-profile"
                class="secondary-button"
            >
                Pārbaudīt profilu
            </a>

        </section>

    </main>

</body>
</html>