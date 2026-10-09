
<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rediģēt mājdzīvnieku - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-owner-nav />

    <main class="page-container">

        <!-- LAPAS GALVENE -->
        <section class="pet-form-header">

            <div class="pet-form-header-icon">
                🐾
            </div>

            <div>
                <p class="section-label">
                    Mani mājdzīvnieki
                </p>

                <h1 class="page-title">
                    Rediģēt mājdzīvnieku
                </h1>

                <p class="page-description">
                    Atjaunini informāciju par savu mājdzīvnieku,
                    lai pieskatītājam vienmēr būtu pieejami pareizi dati.
                </p>
            </div>

        </section>

        <!-- SATURS -->
        <section class="pet-form-layout">

            <!-- FORMA -->
            <div class="pet-form-card">

                <div class="pet-form-card-heading">

                    <div>
                        <p class="section-label">
                            Mājdzīvnieka informācija
                        </p>

                        <h2>
                            Rediģē sava mīluļa datus
                        </h2>
                    </div>

                    <span class="required-note">
                        * Obligātie lauki
                    </span>

                </div>

                <!-- KĻŪDAS -->
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

                <!-- REDIĢĒŠANAS FORMA -->
                <form
                    action="{{ route('pets.update', $pet->id) }}"
                    method="POST"
                >

                    @csrf
                    @method('PUT')

                    <!-- VĀRDS + VEIDS -->
                    <div class="pet-form-row">

                        <div class="form-group">
                            <label for="name">
                                Mājdzīvnieka vārds *
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $pet->name) }}"
                                placeholder="Piemēram, Reksis"
                                maxlength="255"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="species">
                                Dzīvnieka veids *
                            </label>

                            <input
                                type="text"
                                id="species"
                                name="species"
                                value="{{ old('species', $pet->species) }}"
                                placeholder="Piemēram, Suns"
                                maxlength="255"
                                required
                            >
                        </div>

                    </div>

                    <!-- ŠĶIRNE -->
                    <div class="form-group">

                        <label for="breed">
                            Šķirne
                        </label>

                        <input
                            type="text"
                            id="breed"
                            name="breed"
                            value="{{ old('breed', $pet->breed) }}"
                            placeholder="Piemēram, Labradors"
                            maxlength="255"
                        >

                        <span class="form-help">
                            Ja šķirne nav zināma, šo lauku vari atstāt tukšu.
                        </span>

                    </div>

                    <!-- VECUMS + SVARS -->
                    <div class="pet-form-row">

                        <div class="form-group">

                            <label for="age">
                                Vecums
                            </label>

                            <div class="input-with-symbol">

                                <input
                                    type="number"
                                    id="age"
                                    name="age"
                                    value="{{ old('age', $pet->age) }}"
                                    min="0"
                                    step="1"
                                    placeholder="Piemēram, 3"
                                    onwheel="this.blur()"
                                >

                                <span>gadi</span>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="weight">
                                Svars
                            </label>

                            <div class="input-with-symbol">

                                <input
                                    type="number"
                                    id="weight"
                                    name="weight"
                                    value="{{ old('weight', $pet->weight) }}"
                                    min="0"
                                    max="999.99"
                                    step="0.01"
                                    placeholder="Piemēram, 12.5"
                                    onwheel="this.blur()"
                                >

                                <span>kg</span>

                            </div>

                        </div>

                    </div>

                    <!-- ĪPAŠĀS PRASĪBAS -->
                    <div class="form-group">

                        <label for="special_requirements">
                            Īpašās prasības
                        </label>

                        <textarea
                            id="special_requirements"
                            name="special_requirements"
                            maxlength="10000"
                            placeholder="Piemēram, medikamenti, barošanas paradumi, uzvedība vai cita svarīga informācija..."
                        >{{ old('special_requirements', $pet->special_requirements) }}</textarea>

                        <span class="form-help">
                            Norādi informāciju, kas pieskatītājam būtu jāzina
                            par tava mājdzīvnieka aprūpi.
                        </span>

                    </div>

                    <!-- ESOŠIE ATTĒLI -->
                    @if ($pet->images->isNotEmpty())

                        <div class="pet-image-upload">

                            <div class="pet-image-upload-heading">
                                <div>
                                    <label>
                                        Esošie mājdzīvnieka attēli
                                    </label>

                                    <p>
                                        Rediģējot informāciju, šie attēli tiks saglabāti.
                                    </p>
                                </div>
                            </div>

                            <div class="image-preview">

                                @foreach ($pet->images as $image)
                                    <div class="image-preview-item">

                                        <img
                                            src="{{ asset('storage/' . $image->image) }}"
                                            alt="Mājdzīvnieka attēls"
                                        >

                                    </div>
                                @endforeach

                            </div>

                        </div>

                    @endif

                    <!-- POGAS -->
                    <div class="pet-form-actions">

                        <button
                            type="submit"
                            class="main-button"
                        >
                            💾 Saglabāt izmaiņas
                        </button>

                        <a
                            href="/pets"
                            class="secondary-button"
                        >
                            Atcelt
                        </a>

                    </div>

                </form>

            </div>

            <!-- LABĀ PUSE -->
            <aside class="pet-form-side-card">

                <div class="pet-form-side-icon">
                    🐶
                </div>

                <h3>
                    Kāpēc atjaunināt informāciju?
                </h3>

                <p>
                    Pareiza informācija par mājdzīvnieku palīdz
                    pieskatītājam nodrošināt piemērotu aprūpi.
                </p>

                <div class="pet-form-tip">
                    <span>✓</span>

                    <p>
                        Pārbaudi mājdzīvnieka vecumu un svaru.
                    </p>
                </div>

                <div class="pet-form-tip">
                    <span>✓</span>

                    <p>
                        Atjaunini informāciju par īpašām aprūpes prasībām.
                    </p>
                </div>

                <div class="pet-form-tip">
                    <span>✓</span>

                    <p>
                        Esošie attēli paliks saglabāti.
                    </p>
                </div>

                <div class="pet-form-tip">
                    <span>✓</span>

                    <p>
                        Izmaiņas vari saglabāt jebkurā laikā.
                    </p>
                </div>

            </aside>

        </section>

    </main>

</body>
</html>
