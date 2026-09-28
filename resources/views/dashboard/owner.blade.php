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

        <!-- SVEICIENA BLOKS -->

        <section class="dashboard-hero">

            <div class="dashboard-hero-content">

                <p class="section-label">
                    Mājdzīvnieka īpašnieka panelis
                </p>

                <h1>
                    Sveiks, {{ auth()->user()->name }}!
                </h1>

                <p>
                    Pārvaldi savus mājdzīvniekus, atrodi piemērotu
                    pieskatītāju un apskati savas rezervācijas vienuviet.
                </p>

                <div class="dashboard-hero-actions">

                    <a
                        href="/sitters"
                        class="main-button"
                    >
                        🔎 Atrast pieskatītāju
                    </a>

                    <a
                        href="/pets"
                        class="secondary-button"
                    >
                        Mani mājdzīvnieki
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

                <!-- MĀJDZĪVNIEKI -->

                <article class="dashboard-action-card">

                    <div class="dashboard-action-icon">
                        🐶
                    </div>

                    <div class="dashboard-action-content">

                        <h3>
                            Mani mājdzīvnieki
                        </h3>

                        <p>
                            Pievieno jaunus mājdzīvniekus un pārvaldi
                            informāciju par jau pievienotajiem.
                        </p>

                    </div>

                    <a
                        href="/pets"
                        class="dashboard-card-link"
                    >
                        Apskatīt mājdzīvniekus
                        <span>→</span>
                    </a>

                </article>


                <!-- PIESKATĪTĀJI -->

                <article class="dashboard-action-card">

                    <div class="dashboard-action-icon">
                        🐾
                    </div>

                    <div class="dashboard-action-content">

                        <h3>
                            Pieskatītāji
                        </h3>

                        <p>
                            Meklē piemērotu mājdzīvnieku pieskatītāju
                            pēc pilsētas, cenas un vērtējuma.
                        </p>

                    </div>

                    <a
                        href="/sitters"
                        class="dashboard-card-link"
                    >
                        Meklēt pieskatītāju
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
                            Manas rezervācijas
                        </h3>

                        <p>
                            Apskati veiktos rezervāciju pieprasījumus,
                            to statusus un sazinies ar pieskatītājiem.
                        </p>

                    </div>

                    <a
                        href="/bookings"
                        class="dashboard-card-link"
                    >
                        Skatīt rezervācijas
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
                    Pirms rezervācijas
                </h3>

                <p>
                    Pārliecinies, ka esi pievienojis informāciju par
                    savu mājdzīvnieku. Tas palīdzēs pieskatītājam
                    labāk sagatavoties tā aprūpei.
                </p>

            </div>

            <a
                href="/pets"
                class="secondary-button"
            >
                Mani mājdzīvnieki
            </a>

        </section>

    </main>

</body>
</html>