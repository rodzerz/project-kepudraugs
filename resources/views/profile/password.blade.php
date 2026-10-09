
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mainīt paroli - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    @if (auth()->user()->role === 'owner')

        <x-owner-nav />

    @elseif (auth()->user()->role === 'sitter')

        <x-sitter-nav />

    @endif


    <main class="page-container">

        <!-- LAPAS GALVENE -->

        <section class="account-page-header">

            <div>

                <p class="section-label">
                    Mans konts
                </p>

                <h1 class="page-title">
                    Mainīt paroli
                </h1>

                <p class="page-description">
                    Atjauno sava ĶepuDraugs.lv konta paroli,
                    lai uzturētu konta drošību.
                </p>

            </div>

        </section>


        <!-- PAROLES MAIŅAS BLOKS -->

        <section class="account-edit-layout">

            <!-- FORMA -->

            <div class="account-edit-card">

                <div class="account-edit-heading">

                    <div class="account-edit-user">

                        <div class="account-avatar account-avatar-small">
                            {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div>

                            <p class="section-label">
                                Konta drošība
                            </p>

                            <h2>
                                {{ auth()->user()->name }}
                            </h2>

                        </div>

                    </div>

                    @if (auth()->user()->role === 'owner')

                        <span class="account-role">
                            🐾 Mājdzīvnieka īpašnieks
                        </span>

                    @elseif (auth()->user()->role === 'sitter')

                        <span class="account-role">
                            🐕 Mājdzīvnieku pieskatītājs
                        </span>

                    @elseif (auth()->user()->role === 'admin')

                        <span class="account-role">
                            Administrators
                        </span>

                    @endif

                </div>


                <!-- KĻŪDU PAZIŅOJUMI -->

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            Lūdzu, pārbaudi ievadītās paroles.
                        </strong>

                        <div class="form-error-list">

                            @foreach ($errors->all() as $error)

                                <p>
                                    • {{ $error }}
                                </p>

                            @endforeach

                        </div>

                    </div>

                @endif


                <!-- PAROLES MAIŅAS FORMA -->

                <form action="{{ route('password.update') }}" method="POST">

                    @csrf
                    @method('PUT')


                    <!-- PAŠREIZĒJĀ PAROLE -->

                    <div class="form-group">

                        <label for="current_password">
                            Pašreizējā parole
                        </label>

                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            placeholder="Ievadi pašreizējo paroli"
                            autocomplete="current-password"
                            required
                        >

                        <span class="form-help">
                            Drošības nolūkos ievadi savu pašreizējo paroli.
                        </span>

                    </div>


                    <!-- JAUNĀ PAROLE -->

                    <div class="form-group">

                        <label for="password">
                            Jaunā parole
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Ievadi jauno paroli"
                            autocomplete="new-password"
                            minlength="8"
                            required
                        >

                        <span class="form-help">
                            Vismaz 8 simboli, viens lielais burts un viens cipars.
                        </span>

                    </div>


                    <!-- JAUNĀS PAROLES APSTIPRINĀJUMS -->

                    <div class="form-group">

                        <label for="password_confirmation">
                            Apstiprini jauno paroli
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Atkārtoti ievadi jauno paroli"
                            autocomplete="new-password"
                            minlength="8"
                            required
                        >

                        <span class="form-help">
                            Abām jaunās paroles ievadēm jāsakrīt.
                        </span>

                    </div>


                    <!-- POGAS -->

                    <div class="account-edit-actions">

                        <button
                            type="submit"
                            class="main-button"
                        >
                            Nomainīt paroli
                        </button>

                        <a
                            href="/profile"
                            class="secondary-button"
                        >
                            Atcelt
                        </a>

                    </div>

                </form>

            </div>


            <!-- INFORMĀCIJAS KARTĪTE -->

            <aside class="account-edit-side">

                <div class="account-edit-side-icon">
                    🔐
                </div>

                <h3>
                    Paroles drošība
                </h3>

                <p>
                    Izvēlies drošu paroli, kuru neizmanto citos
                    interneta pakalpojumos.
                </p>


                <div class="account-edit-tip">

                    <span>✓</span>

                    <p>
                        Parolei jābūt vismaz 8 simbolus garai.
                    </p>

                </div>


                <div class="account-edit-tip">

                    <span>✓</span>

                    <p>
                        Izmanto vismaz vienu lielo burtu un vienu ciparu.
                    </p>

                </div>


                <div class="account-edit-tip">

                    <span>✓</span>

                    <p>
                        Jaunajai parolei jāatšķiras no pašreizējās.
                    </p>

                </div>


                <div class="account-edit-tip">

                    <span>✓</span>

                    <p>
                        Nekad neatklāj savu paroli citiem cilvēkiem.
                    </p>

                </div>

            </aside>

        </section>

    </main>

</body>
</html>
