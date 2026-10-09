
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mans profils - ĶepuDraugs.lv</title>

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
                    Mans profils
                </h1>

                <p class="page-description">
                    Apskati un pārvaldi sava ĶepuDraugs.lv konta
                    pamatinformāciju.
                </p>

            </div>

        </section>


        @if (session('success'))

            <div class="alert alert-success">
                <strong>{{ session('success') }}</strong>
            </div>

        @endif


        <!-- PROFILA KARTĪTE -->

        <section class="account-profile-card">

            <div class="account-profile-top">

                <div class="account-avatar">
                    {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                </div>


                <div class="account-profile-identity">

                    <p class="section-label">
                        ĶepuDraugs.lv lietotājs
                    </p>

                    <h2>
                        {{ $user->name }}
                    </h2>


                    @if ($user->role === 'owner')

                        <span class="account-role">
                            🐾 Mājdzīvnieka īpašnieks
                        </span>

                    @elseif ($user->role === 'sitter')

                        <span class="account-role">
                            🐕 Mājdzīvnieku pieskatītājs
                        </span>

                    @elseif ($user->role === 'admin')

                        <span class="account-role">
                            Administrators
                        </span>

                    @endif

                </div>


                <!-- PROFILA DARBĪBAS -->

                <div class="account-profile-action">

                    <a
                        href="/profile/edit"
                        class="main-button"
                    >
                        ✏️ Rediģēt profilu
                    </a>

                    <a
                        href="{{ route('password.edit') }}"
                        class="secondary-button"
                    >
                        🔐 Mainīt paroli
                    </a>

                </div>

            </div>


            <div class="account-profile-divider"></div>


            <!-- KONTA INFORMĀCIJA -->

            <div class="account-info-heading">

                <h3>
                    Konta informācija
                </h3>

                <p>
                    Šeit redzama tava konta pamatinformācija.
                </p>

            </div>


            <div class="account-info-grid">

                <!-- VĀRDS -->

                <div class="account-info-item">

                    <div class="account-info-icon">
                        👤
                    </div>

                    <div>

                        <span class="account-info-label">
                            Vārds
                        </span>

                        <strong>
                            {{ $user->name }}
                        </strong>

                    </div>

                </div>


                <!-- E-PASTS -->

                <div class="account-info-item">

                    <div class="account-info-icon">
                        ✉️
                    </div>

                    <div>

                        <span class="account-info-label">
                            E-pasts
                        </span>

                        <strong>
                            {{ $user->email }}
                        </strong>

                    </div>

                </div>


                <!-- LOMA -->

                <div class="account-info-item">

                    <div class="account-info-icon">
                        🐾
                    </div>

                    <div>

                        <span class="account-info-label">
                            Lietotāja veids
                        </span>

                        <strong>

                            @if ($user->role === 'owner')

                                Mājdzīvnieka īpašnieks

                            @elseif ($user->role === 'sitter')

                                Mājdzīvnieku pieskatītājs

                            @elseif ($user->role === 'admin')

                                Administrators

                            @endif

                        </strong>

                    </div>

                </div>

            </div>

        </section>

    </main>

</body>
</html>
