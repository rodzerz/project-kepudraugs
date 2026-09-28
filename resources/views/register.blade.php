<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reģistrācija - ĶepuDraugs.lv</title>

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
                    Jau ir konts?
                </span>

                <a href="/login" class="secondary-button">
                    Ielogoties
                </a>

            </div>

        </div>
    </header>


    <main class="auth-main">

        <div class="auth-container">

            <div class="auth-intro">

                <div class="auth-icon">
                    🐾
                </div>

                <p class="section-label">
                    Pievienojies ĶepuDraugs.lv
                </p>

                <h1>
                    Izveido savu kontu
                </h1>

                <p>
                    Reģistrējies kā mājdzīvnieka īpašnieks vai
                    pieskatītājs un izmanto ĶepuDraugs.lv iespējas.
                </p>

                <div class="auth-benefits">

                    <div class="auth-benefit">
                        <span>✓</span>
                        <p>
                            Atrodi piemērotus mājdzīvnieku pieskatītājus
                        </p>
                    </div>

                    <div class="auth-benefit">
                        <span>✓</span>
                        <p>
                            Veic un pārvaldi rezervācijas vienuviet
                        </p>
                    </div>

                    <div class="auth-benefit">
                        <span>✓</span>
                        <p>
                            Sazinies un apskati citu lietotāju atsauksmes
                        </p>
                    </div>

                </div>

            </div>


            <div class="auth-card">

                <div class="auth-card-heading">

                    <h2>
                        Reģistrācija
                    </h2>

                    <p>
                        Aizpildi informāciju, lai izveidotu savu kontu.
                    </p>

                </div>


                @if ($errors->any())

                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>

                @endif


                <form action="/register" method="POST">

                    @csrf


                    <div class="form-group">

                        <label for="name">
                            Vārds
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ievadi savu vārdu"
                            required
                        >

                    </div>


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
                            placeholder="Vismaz 6 rakstzīmes"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="password_confirmation">
                            Atkārtota parole
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Atkārto paroli"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="role">
                            Lietotāja veids
                        </label>

                        <select
                            id="role"
                            name="role"
                            required
                        >

                            <option value="">
                                Izvēlies lietotāja veidu
                            </option>

                            <option
                                value="owner"
                                {{ old('role') === 'owner' ? 'selected' : '' }}
                            >
                                Mājdzīvnieka īpašnieks
                            </option>

                            <option
                                value="sitter"
                                {{ old('role') === 'sitter' ? 'selected' : '' }}
                            >
                                Mājdzīvnieku pieskatītājs
                            </option>

                        </select>

                    </div>


                    <button
                        type="submit"
                        class="auth-submit-button"
                    >
                        Izveidot kontu
                    </button>

                </form>


                <div class="auth-login-link">

                    <span>
                        Jau ir konts?
                    </span>

                    <a href="/login">
                        Ielogoties
                    </a>

                </div>

            </div>

        </div>

    </main>

</body>
</html>