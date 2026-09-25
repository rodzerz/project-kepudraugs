<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ĶepuDraugs.lv - Mājdzīvnieku pieskatīšana</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- NAVIGĀCIJA -->
    <header class="header">
        <div class="header-content">

            <a href="/" class="logo">
                <span class="logo-icon">🐾</span>
                ĶepuDraugs.lv
            </a>

            <div class="header-actions">

                <a href="#ka-tas-darbojas" class="header-link">
                    Kā tas darbojas?
                </a>

                <a href="/login" class="secondary-button">
                    Ielogoties
                </a>

                <a href="/register" class="main-button">
                    Reģistrēties
                </a>

            </div>

        </div>
    </header>


    <main>

        <!-- GALVENĀ SADAĻA -->
        <section class="home-hero">

            <div class="home-hero-overlay"></div>

            <div class="home-hero-content">

                <div class="home-hero-card">

                    <p class="hero-label">
                        🐾 Mājdzīvnieku pieskatīšana vienuviet
                    </p>

                    <h1>
                        Atrodi uzticamu
                        <span>pieskatītāju</span>
                        savam mīlulim.
                    </h1>

                    <p class="home-hero-description">
                        Atrodi piemērotu mājdzīvnieku pieskatītāju,
                        apskati viņa pieredzi un atsauksmes, veic
                        rezervāciju un sazinies vienuviet.
                    </p>

                    <div class="home-hero-buttons">

                        <a href="/register" class="main-button hero-main-button">
                            Sākt izmantot
                        </a>

                    </div>

                </div>

            </div>

        </section>


        <!-- KĀ TAS DARBOJAS -->
        <section class="how-it-works" id="ka-tas-darbojas">

            <div class="section-container">

                <div class="section-heading">

                    <p class="section-label">
                        Vienkārši un ērti
                    </p>

                    <h2>
                        Kā darbojas ĶepuDraugs.lv?
                    </h2>

                    <p>
                        Daži vienkārši soļi, lai atrastu piemērotu
                        pieskatītāju savam mājdzīvniekam.
                    </p>

                </div>


                <div class="steps-grid">

                    <!-- 1. SOLIS -->
                    <div class="step-card">

                        <div class="step-number">
                            1
                        </div>

                        <div class="step-icon">
                            🔎
                        </div>

                        <h3>
                            Atrodi pieskatītāju
                        </h3>

                        <p>
                            Meklē pieskatītājus pēc pilsētas un
                            apskati viņu pieredzi, pakalpojumus,
                            cenas un atsauksmes.
                        </p>

                    </div>


                    <!-- 2. SOLIS -->
                    <div class="step-card">

                        <div class="step-number">
                            2
                        </div>

                        <div class="step-icon">
                            📅
                        </div>

                        <h3>
                            Veic rezervāciju
                        </h3>

                        <p>
                            Izvēlies piemērotu datumu un laiku
                            un nosūti rezervācijas pieprasījumu
                            izvēlētajam pieskatītājam.
                        </p>

                    </div>


                    <!-- 3. SOLIS -->
                    <div class="step-card">

                        <div class="step-number">
                            3
                        </div>

                        <div class="step-icon">
                            💬
                        </div>

                        <h3>
                            Sazinies
                        </h3>

                        <p>
                            Sazinies ar pieskatītāju platformā
                            un vienojies par svarīgāko saistībā
                            ar sava mīluļa aprūpi.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        <!-- KĀPĒC ĶEPUDRAUGS -->
        <section class="home-benefits">

            <div class="section-container">

                <div class="benefits-layout">

                    <div class="benefits-text">

                        <p class="section-label">
                            Kāpēc ĶepuDraugs.lv?
                        </p>

                        <h2>
                            Viss nepieciešamais tava mīluļa aprūpei
                        </h2>

                        <p class="benefits-description">
                            ĶepuDraugs.lv apvieno mājdzīvnieku
                            īpašniekus un pieskatītājus vienā
                            pārskatāmā platformā.
                        </p>


                        <!-- PIESKATĪTĀJU PROFILI -->
                        <div class="benefit-item">

                            <div class="benefit-icon">
                                ✓
                            </div>

                            <div>

                                <h3>
                                    Pieskatītāju profili
                                </h3>

                                <p>
                                    Apskati pieredzi, atrašanās vietu,
                                    piedāvātos pakalpojumus un cenas.
                                </p>

                            </div>

                        </div>


                        <!-- ATSAUKSMES -->
                        <div class="benefit-item">

                            <div class="benefit-icon">
                                ✓
                            </div>

                            <div>

                                <h3>
                                    Atsauksmes un vērtējumi
                                </h3>

                                <p>
                                    Apskati citu mājdzīvnieku īpašnieku
                                    atstātos vērtējumus.
                                </p>

                            </div>

                        </div>


                        <!-- REZERVĀCIJAS -->
                        <div class="benefit-item">

                            <div class="benefit-icon">
                                ✓
                            </div>

                            <div>

                                <h3>
                                    Rezervācijas un saziņa
                                </h3>

                                <p>
                                    Pārvaldi rezervācijas un sazinies
                                    ar pieskatītāju vienuviet.
                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- INFORMATĪVAIS BLOKS -->
                    <div class="benefits-card">

                        <div class="benefits-paw">
                            🐾
                        </div>

                        <h3>
                            Rūpes par mīluli kļūst vienkāršākas.
                        </h3>

                        <p>
                            Atrodi pieskatītāju, pārvaldi rezervācijas
                            un sazinies ar pieskatītāju vienā ērtā
                            platformā.
                        </p>

                    </div>

                </div>

            </div>

        </section>

    </main>


    <!-- FOOTER -->
    <footer class="site-footer">

        <div class="footer-content">

            <div>

                <a href="/" class="footer-logo">
                    🐾 ĶepuDraugs.lv
                </a>

                <p>
                    Ērta mājdzīvnieku pieskatīšana vienuviet.
                </p>

            </div>

        </div>


        <div class="footer-bottom">

            <p>
                © {{ date('Y') }} ĶepuDraugs.lv
            </p>

        </div>

    </footer>

</body>
</html>