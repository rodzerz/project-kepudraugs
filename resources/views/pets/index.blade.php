<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mani mājdzīvnieki - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-owner-nav />


    <main class="page-container">

        <!-- LAPAS GALVENE -->

        <section class="pets-page-header">

            <div>

                <p class="section-label">
                    Tavi mājdzīvnieki
                </p>

                <h1 class="page-title">
                    Mani mājdzīvnieki
                </h1>

                <p class="page-description">
                    Apskati un pārvaldi informāciju par saviem
                    pievienotajiem mājdzīvniekiem.
                </p>

            </div>


            <a
                href="/pets/create"
                class="main-button"
            >
                + Pievienot mājdzīvnieku
            </a>

        </section>


        <!-- PAZIŅOJUMS -->

        @if (session('success'))

            <div class="alert alert-success">
                <strong>
                    {{ session('success') }}
                </strong>
            </div>

        @endif


        <!-- MĀJDZĪVNIEKI -->

        @if ($pets->count() > 0)

            <section class="pets-grid">

                @foreach ($pets as $pet)

                    <article class="pet-card">

                        <!-- ATTĒLI -->

                        <div class="pet-card-media">

                            @if ($pet->images->count() > 0)

                                <img
                                    src="{{ asset('storage/' . $pet->images->first()->image) }}"
                                    alt="{{ $pet->name }}"
                                    class="pet-main-image"
                                >

                                @if ($pet->images->count() > 1)

                                    <div class="pet-image-count">
                                        📷 {{ $pet->images->count() }}
                                    </div>

                                @endif

                            @else

                                <div class="pet-no-image">
                                    🐾
                                </div>

                            @endif

                        </div>


                        <!-- GALVENE -->

                        <div class="pet-card-content">

                            <div class="pet-card-heading">

                                <div>

                                    <span class="pet-species">
                                        {{ $pet->species }}
                                    </span>

                                    <h2>
                                        {{ $pet->name }}
                                    </h2>

                                </div>

                                <div class="pet-paw-icon">
                                    🐾
                                </div>

                            </div>


                            <!-- INFORMĀCIJA -->

                            <div class="pet-info-grid">

                                <div class="pet-info-item">

                                    <span>
                                        Šķirne
                                    </span>

                                    <strong>
                                        {{ $pet->breed ?? 'Nav norādīta' }}
                                    </strong>

                                </div>


                                <div class="pet-info-item">

                                    <span>
                                        Vecums
                                    </span>

                                    <strong>
                                        {{ $pet->age !== null
                                            ? $pet->age . ' gadi'
                                            : 'Nav norādīts'
                                        }}
                                    </strong>

                                </div>


                                <div class="pet-info-item">

                                    <span>
                                        Svars
                                    </span>

                                    <strong>
                                        {{ $pet->weight !== null
                                            ? $pet->weight . ' kg'
                                            : 'Nav norādīts'
                                        }}
                                    </strong>

                                </div>

                            </div>


                            <!-- ĪPAŠĀS PRASĪBAS -->

                            <div class="pet-requirements">

                                <span class="pet-requirements-label">
                                    Īpašās prasības
                                </span>

                                <p>
                                    {{ $pet->special_requirements
                                        ?? 'Īpašas prasības nav norādītas.'
                                    }}
                                </p>

                            </div>


                            <!-- PAPILDU ATTĒLI -->

                            @if ($pet->images->count() > 1)

                                <div class="pet-gallery">

                                    @foreach ($pet->images->skip(1) as $image)

                                        <img
                                            src="{{ asset('storage/' . $image->image) }}"
                                            alt="{{ $pet->name }}"
                                            class="pet-gallery-image"
                                        >

                                    @endforeach

                                </div>

                            @endif


                            <!-- DZĒŠANA -->

                            <div class="pet-card-actions">

                                <form
                                    action="/pets/{{ $pet->id }}"
                                    method="POST"
                                    onsubmit="return confirm('Vai tiešām vēlies izdzēst {{ $pet->name }}?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="danger-button"
                                    >
                                        🗑️ Dzēst mājdzīvnieku
                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                @endforeach

            </section>


        @else

            <!-- TUKŠS STĀVOKLIS -->

            <section class="pets-empty-state">

                <div class="empty-state-icon">
                    🐶
                </div>

                <h2>
                    Tev vēl nav pievienotu mājdzīvnieku
                </h2>

                <p>
                    Pievieno savu pirmo mājdzīvnieku, lai tā
                    informācija būtu pieejama tavā ĶepuDraugs.lv kontā.
                </p>

                <a
                    href="/pets/create"
                    class="main-button"
                >
                    + Pievienot mājdzīvnieku
                </a>

            </section>

        @endif

    </main>

</body>
</html>