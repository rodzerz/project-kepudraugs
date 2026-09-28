<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rediģēt profilu - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    @if ($user->role === 'owner')

        <x-owner-nav />

    @elseif ($user->role === 'sitter')

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
                    Rediģēt profilu
                </h1>

                <p class="page-description">
                    Maini sava ĶepuDraugs.lv konta pamatinformāciju.
                </p>

            </div>

        </section>


        <!-- REDIĢĒŠANAS BLOKS -->

        <section class="account-edit-layout">

            <!-- FORMA -->

            <div class="account-edit-card">

                <div class="account-edit-heading">

                    <div class="account-edit-user">

                        <div class="account-avatar account-avatar-small">
                            {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                        </div>

                        <div>

                            <p class="section-label">
                                Profila informācija
                            </p>

                            <h2>
                                {{ $user->name }}
                            </h2>

                        </div>

                    </div>

                    @if ($user->role === 'owner')

                        <span class="account-role">
                            🐾 Mājdzīvnieka īpašnieks
                        </span>

                    @elseif ($user->role === 'sitter')

                        <span class="account-role">
                            🐕 Mājdzīvnieku pieskatītājs
                        </span>

                    @endif

                </div>


                @if ($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            Lūdzu, pārbaudi ievadīto informāciju.
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


                <form action="/profile" method="POST">

                    @csrf
                    @method('PUT')


                    <!-- VĀRDS -->

                    <div class="form-group">

                        <label for="name">
                            Vārds
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Ievadi savu vārdu"
                            required
                        >

                        <span class="form-help">
                            Vārdam jābūt vismaz 6 rakstzīmes garam.
                        </span>

                    </div>


                    <!-- E-PASTS -->

                    <div class="form-group">

                        <label for="email">
                            E-pasts
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            placeholder="piemers@epasts.lv"
                            required
                        >

                        <span class="form-help">
                            Šis e-pasts tiek izmantots, lai ielogotos tavā kontā.
                        </span>

                    </div>


                    <!-- POGAS -->

                    <div class="account-edit-actions">

                        <button
                            type="submit"
                            class="main-button"
                        >
                            Saglabāt izmaiņas
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
                    👤
                </div>

                <h3>
                    Tava konta informācija
                </h3>

                <p>
                    Pārliecinies, ka norādītais vārds un e-pasta
                    adrese ir pareizi.
                </p>


                <div class="account-edit-tip">

                    <span>✓</span>

                    <p>
                        Izmanto derīgu e-pasta adresi.
                    </p>

                </div>


                <div class="account-edit-tip">

                    <span>✓</span>

                    <p>
                        Norādi savu vārdu, lai citi lietotāji
                        varētu tevi atpazīt.
                    </p>

                </div>


                <div class="account-edit-tip">

                    <span>✓</span>

                    <p>
                        Izmaiņas būs redzamas uzreiz pēc saglabāšanas.
                    </p>

                </div>

            </aside>

        </section>

    </main>

</body>
</html>