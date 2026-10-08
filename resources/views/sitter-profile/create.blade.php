
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $profile ? 'Rediģēt' : 'Izveidot' }} pieskatītāja profilu - ĶepuDraugs.lv
    </title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-sitter-nav />

    <main class="page-container">

        <!-- LAPAS GALVENE -->

        <section class="profile-form-header">

            <div class="profile-form-header-icon">
                🐕
            </div>

            <div>
                <p class="section-label">
                    Pieskatītāja profils
                </p>

                <h1 class="page-title">
                    {{ $profile ? 'Rediģēt pieskatītāja profilu' : 'Izveido savu pieskatītāja profilu' }}
                </h1>

                <p class="page-description">
                    @if ($profile)
                        Atjaunini informāciju par sevi, savu pieredzi un
                        mājdzīvniekiem, kurus esi gatavs pieskatīt.
                    @else
                        Norādi informāciju par sevi, savu pieredzi un
                        mājdzīvniekiem, kurus esi gatavs pieskatīt.
                        Šī informācija būs redzama mājdzīvnieku īpašniekiem.
                    @endif
                </p>
            </div>

        </section>


        <!-- FORMA -->

        <section class="profile-form-layout">

            <div class="profile-form-card">

                <div class="profile-form-card-heading">

                    <div>
                        <p class="section-label">
                            Profila informācija
                        </p>

                        <h2>
                            {{ $profile ? 'Atjaunini savu informāciju' : 'Pastāsti par sevi' }}
                        </h2>
                    </div>

                    <span class="required-note">
                        * Obligātie lauki
                    </span>

                </div>


                @if ($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            Lūdzu, pārbaudi ievadīto informāciju.
                        </strong>

                        <div class="form-error-list">

                            @foreach ($errors->all() as $error)
                                <p>• {{ $error }}</p>
                            @endforeach

                        </div>

                    </div>

                @endif


                <form action="/sitter-profile" method="POST">

                    @csrf


                    <!-- PILSĒTA -->

                    <div class="form-group">

                        <label for="city">
                            Pilsēta *
                        </label>

                        <input
                            type="text"
                            id="city"
                            name="city"
                            value="{{ old('city', $profile?->city) }}"
                            placeholder="Piemēram, Rīga"
                            required
                        >

                        <span class="form-help">
                            Norādi pilsētu, kurā piedāvā pieskatīšanas pakalpojumus.
                        </span>

                    </div>


                    <!-- PAR SEVI -->

                    <div class="form-group">

                        <label for="description">
                            Par sevi
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            placeholder="Pastāsti nedaudz par sevi..."
                        >{{ old('description', $profile?->description) }}</textarea>

                        <span class="form-help">
                            Īss apraksts palīdz mājdzīvnieku īpašniekiem
                            labāk tevi iepazīt.
                        </span>

                    </div>


                    <!-- PIEREDZE -->

                    <div class="form-group">

                        <label for="experience">
                            Pieredze
                        </label>

                        <textarea
                            id="experience"
                            name="experience"
                            placeholder="Apraksti savu pieredzi darbā ar mājdzīvniekiem..."
                        >{{ old('experience', $profile?->experience) }}</textarea>

                        <span class="form-help">
                            Apraksti iepriekšējo pieredzi ar suņiem,
                            kaķiem vai citiem mājdzīvniekiem.
                        </span>

                    </div>


                    <!-- CENA + DZĪVNIEKI -->

                    <div class="profile-form-row">

                        <div class="form-group">

                            <label for="price">
                                Cena (€ / dienā) *
                            </label>

                            <div class="input-with-symbol">

                                <input
                                    type="number"
                                    id="price"
                                    name="price"
                                    value="{{ old('price', $profile?->price) }}"
                                    min="0"
                                    max="999999.99"
                                    step="0.01"
                                    placeholder="15.00"
                                    required
                                >

                                <span>
                                    €
                                </span>

                            </div>

                        </div>


                        <div class="form-group">

                            <label for="accepted_animals">
                                Pieskatāmie dzīvnieki *
                            </label>

                            <input
                                type="text"
                                id="accepted_animals"
                                name="accepted_animals"
                                value="{{ old('accepted_animals', $profile?->accepted_animals) }}"
                                placeholder="Suņi, kaķi, truši"
                                required
                            >

                        </div>

                    </div>


                    <!-- SAGLABĀŠANA -->

                    <div class="profile-form-footer">

                        <div class="profile-form-footer-text">
                            <span>🐾</span>

                            <p>
                                Profila informāciju vēlāk varēsi mainīt.
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="main-button profile-save-button"
                        >
                            {{ $profile ? 'Saglabāt izmaiņas' : 'Izveidot profilu' }}
                        </button>

                    </div>

                </form>

            </div>


            <!-- LABĀ INFORMĀCIJAS KARTĪTE -->

            <aside class="profile-form-side-card">

                <div class="profile-side-icon">
                    💡
                </div>

                <h3>
                    Kā izveidot labu profilu?
                </h3>

                <p>
                    Pilnīgāka informācija palīdz mājdzīvnieku
                    īpašniekiem saprast, vai esi piemērots viņu mīlulim.
                </p>

                <div class="profile-tip">
                    <span>✓</span>
                    <p>Norādi savu pieredzi ar mājdzīvniekiem.</p>
                </div>

                <div class="profile-tip">
                    <span>✓</span>
                    <p>Skaidri norādi, kādus dzīvniekus pieskati.</p>
                </div>

                <div class="profile-tip">
                    <span>✓</span>
                    <p>Izvēlies atbilstošu cenu par vienu dienu.</p>
                </div>

                <div class="profile-tip">
                    <span>✓</span>
                    <p>Uzraksti īsu un saprotamu aprakstu par sevi.</p>
                </div>

            </aside>

        </section>

    </main>

</body>
</html>
