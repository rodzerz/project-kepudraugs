<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mājdzīvnieku pārvaldība - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- ADMINISTRATORA NAVIGĀCIJA -->

    <header class="header admin-header">

        <div class="header-content">

            <a href="/admin" class="logo">

                <span class="logo-icon">
                    🐾
                </span>

                <span>
                    ĶepuDraugs.lv
                </span>

                <span class="admin-logo-badge">
                    Admin
                </span>

            </a>


            <nav class="main-nav">

                <a href="/admin">
                    Lietotāji
                </a>

                <a href="/admin/bookings">
                    Rezervācijas
                </a>

                <a
                    href="/admin/pets"
                    class="active"
                >
                    Mājdzīvnieki
                </a>


                <form
                    action="/logout"
                    method="POST"
                    class="logout-form"
                >

                    @csrf

                    <button
                        type="submit"
                        class="logout-button"
                    >
                        Iziet
                    </button>

                </form>

            </nav>

        </div>

    </header>


    <main class="page-container">

        <!-- LAPAS GALVENE -->

        <section class="admin-page-header">

            <div>

                <p class="section-label">
                    Administratora panelis
                </p>

                <h1 class="page-title">
                    Mājdzīvnieku pārvaldība
                </h1>

                <p class="page-description">
                    Apskati lietotāju pievienotos mājdzīvniekus
                    un nepieciešamības gadījumā noņem neatbilstošu saturu.
                </p>

            </div>


            <div class="admin-page-header-icon">
                🐕
            </div>

        </section>


        <!-- PAZIŅOJUMS -->

        @if (session('success'))

            <div class="alert alert-success">

                <strong>
                    {{ session('success') }}
                </strong>

            </div>

        @endif


        @if ($pets->count() > 0)

            <!-- REZULTĀTU GALVENE -->

            <section class="admin-results-heading">

                <div>

                    <p class="section-label">
                        Sistēmas saturs
                    </p>

                    <h2>
                        Pievienotie mājdzīvnieki
                    </h2>

                </div>

                <span class="admin-results-count">
                    {{ $pets->count() }}
                    {{ $pets->count() == 1 ? 'mājdzīvnieks' : 'mājdzīvnieki' }}
                </span>

            </section>


            <!-- MĀJDZĪVNIEKU REŽĢIS -->

            <section class="admin-pets-grid">

                @foreach ($pets as $pet)

                    <article class="admin-pet-card">

                        <!-- ATTĒLS -->

                        <div class="admin-pet-media">

                            @if ($pet->images->count() > 0)

                                <img
                                    src="{{ asset('storage/' . $pet->images->first()->image) }}"
                                    alt="{{ $pet->name }}"
                                    class="admin-pet-main-image"
                                >

                                @if ($pet->images->count() > 1)

                                    <span class="admin-pet-image-count">
                                        📷 {{ $pet->images->count() }}
                                    </span>

                                @endif

                            @else

                                <div class="admin-pet-no-image">
                                    🐾
                                </div>

                            @endif

                        </div>


                        <!-- SATURS -->

                        <div class="admin-pet-content">

                            <div class="admin-pet-heading">

                                <div>

                                    <span class="admin-pet-species">
                                        {{ $pet->species }}
                                    </span>

                                    <h2>
                                        {{ $pet->name }}
                                    </h2>

                                </div>

                                <div class="admin-pet-icon">
                                    🐾
                                </div>

                            </div>


                            <!-- ĪPAŠNIEKS -->

                            <div class="admin-pet-owner">

                                <div class="admin-pet-owner-avatar">
                                    {{ mb_strtoupper(mb_substr($pet->user->name, 0, 1)) }}
                                </div>

                                <div>

                                    <span>
                                        Īpašnieks
                                    </span>

                                    <strong>
                                        {{ $pet->user->name }}
                                    </strong>

                                </div>

                            </div>


                            <!-- INFORMĀCIJA -->

                            <div class="admin-pet-info-grid">

                                <div class="admin-pet-info-item">

                                    <span>
                                        Šķirne
                                    </span>

                                    <strong>
                                        {{ $pet->breed ?? 'Nav norādīta' }}
                                    </strong>

                                </div>


                                <div class="admin-pet-info-item">

                                    <span>
                                        Vecums
                                    </span>

                                    <strong>
                                        {{ $pet->age !== null ? $pet->age . ' gadi' : 'Nav norādīts' }}
                                    </strong>

                                </div>


                                <div class="admin-pet-info-item">

                                    <span>
                                        Svars
                                    </span>

                                    <strong>
                                        {{ $pet->weight !== null ? $pet->weight . ' kg' : 'Nav norādīts' }}
                                    </strong>

                                </div>

                            </div>


                            <!-- ĪPAŠĀS PRASĪBAS -->

                            <div class="admin-pet-requirements">

                                <span>
                                    Īpašās prasības
                                </span>

                                <p>
                                    {{ $pet->special_requirements ?? 'Īpašas prasības nav norādītas.' }}
                                </p>

                            </div>


                            <!-- PAPILDU ATTĒLI -->

                            @if ($pet->images->count() > 1)

                                <div class="admin-pet-gallery">

                                    @foreach ($pet->images->skip(1) as $image)

                                        <img
                                            src="{{ asset('storage/' . $image->image) }}"
                                            alt="{{ $pet->name }}"
                                            class="admin-pet-gallery-image"
                                        >

                                    @endforeach

                                </div>

                            @endif


                            <!-- ADMINISTRATORA DARBĪBA -->

                            <div class="admin-pet-actions">

                                <form
                                    action="/admin/pets/{{ $pet->id }}"
                                    method="POST"
                                    onsubmit="return confirm('Vai tiešām vēlaties noņemt šo mājdzīvnieku un tā saturu?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="danger-button"
                                    >
                                        🗑️ Noņemt mājdzīvnieku
                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                @endforeach

            </section>


        @else

            <!-- TUKŠS STĀVOKLIS -->

            <section class="admin-empty-state">

                <div class="empty-state-icon">
                    🐾
                </div>

                <h2>
                    Sistēmā nav mājdzīvnieku
                </h2>

                <p>
                    Pašlaik neviens lietotājs sistēmā nav
                    pievienojis mājdzīvnieku.
                </p>

            </section>

        @endif

    </main>

</body>
</html>