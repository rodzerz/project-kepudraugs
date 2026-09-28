<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ielogošanās - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="auth-page">

    <header class="header">
        <div class="header-content">

            <a href="/" class="logo">
                <span class="logo-icon">🐾</span>
                ĶepuDraugs.lv
            </a>

            <div class="header-actions">

                <span class="auth-header-text">
                    Vēl nav konta?
                </span>

                <a href="/register" class="main-button">
                    Reģistrēties
                </a>

            </div>

        </div>
    </header>


    <main class="auth-main">

        <div class="auth-container">

            <!-- Kreisā puse -->

            <div class="auth-intro">

                <div class="auth-icon">
                    🐾
                </div>

                <p class="section-label">
                    ĶepuDraugs.lv
                </p>

                <h1>
                    Laipni lūdzam atpakaļ!
                </h1>

                <p>
                    Ielogojies savā kontā un turpini pārvaldīt
                    mājdzīvniekus, rezervācijas un saziņu vienuviet.
                </p>

                <div class="auth-benefits">

                    <div class="auth-benefit">
                        <span>✓</span>

                        <p>
                            Pārvaldi savas rezervācijas
                        </p>
                    </div>

                    <div class="auth-benefit">
                        <span>✓</span>

                        <p>
                            Sazinies ar īpašniekiem un pieskatītājiem
                        </p>
                    </div>

                    <div class="auth-benefit">
                        <span>✓</span>

                        <p>
                            Ērti piekļūsti savam profilam un informācijai
                        </p>
                    </div>

                </div>

            </div>


            <!-- Labā puse -->

            <div class="auth-card">

                <div class="auth-card-heading">

                    <h2>
                        Ielogoties
                    </h2>

                    <p>
                        Ievadi sava konta piekļuves datus.
                    </p>

                </div>


                @if ($errors->any())

                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>

                @endif


                <form action="/login" method="POST">

                    @csrf


                    <div class="form-group">

                        <label for="email">
                            E-pasts
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="piemers@epasts.lv"
                            autocomplete="email"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="password">
                            Parole
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Ievadi savu paroli"
                            autocomplete="current-password"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        class="auth-submit-button"
                    >
                        Ielogoties
                    </button>

                </form>


                <div class="auth-login-link">

                    <span>
                        Vēl nav konta?
                    </span>

                    <a href="/register">
                        Izveidot kontu
                    </a>

                </div>

            </div>

        </div>

    </main>

</body>
</html>