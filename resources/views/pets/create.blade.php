<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pievienot mājdzīvnieku - ĶepuDraugs.lv</title>

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
                    Pievienot mājdzīvnieku
                </h1>

                <p class="page-description">
                    Pievieno informāciju par savu mājdzīvnieku,
                    lai pieskatītājam būtu pieejama svarīgākā informācija.
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
                            Pastāsti par savu mīluli
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

                                <p>
                                    • {{ $error }}
                                </p>

                            @endforeach

                        </div>

                    </div>

                @endif


                <form
                    action="/pets"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf


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
                                value="{{ old('name') }}"
                                placeholder="Piemēram, Reksis"
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
                                value="{{ old('species') }}"
                                placeholder="Piemēram, Suns"
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
                            value="{{ old('breed') }}"
                            placeholder="Piemēram, Labradors"
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
                                    value="{{ old('age') }}"
                                    min="0"
                                    placeholder="Piemēram, 3"
                                    onwheel="this.blur()"
                                >

                                <span>
                                    gadi
                                </span>

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
                                    value="{{ old('weight') }}"
                                    min="0"
                                    step="0.01"
                                    placeholder="Piemēram, 12.5"
                                    onwheel="this.blur()"
                                >

                                <span>
                                    kg
                                </span>

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
                            placeholder="Piemēram, medikamenti, barošanas paradumi, uzvedība vai cita svarīga informācija..."
                        >{{ old('special_requirements') }}</textarea>

                        <span class="form-help">
                            Norādi informāciju, kas pieskatītājam būtu jāzina
                            par tava mājdzīvnieka aprūpi.
                        </span>

                    </div>


                    <!-- ATTĒLI -->

                    <div class="pet-image-upload">

                        <div class="pet-image-upload-heading">

                            <div>

                                <label for="images">
                                    Mājdzīvnieka attēli
                                </label>

                                <p>
                                    Pievieno līdz 5 attēliem JPG, PNG vai WEBP formātā.
                                </p>

                            </div>

                            <span id="image-counter" class="image-counter">
                                0 / 5
                            </span>

                        </div>


                        <label
                            for="images"
                            class="pet-upload-area"
                        >

                            <span class="pet-upload-icon">
                                📷
                            </span>

                            <strong>
                                Izvēlies mājdzīvnieka attēlus
                            </strong>

                            <span>
                                Vari izvēlēties vairākus attēlus vienlaikus
                            </span>

                        </label>


                        <input
                            type="file"
                            id="images"
                            name="images[]"
                            accept="image/jpeg,image/png,image/webp"
                            multiple
                            class="pet-file-input"
                        >


                        <div
                            id="image-preview"
                            class="image-preview"
                        ></div>

                    </div>


                    <!-- POGAS -->

                    <div class="pet-form-actions">

                        <button
                            type="submit"
                            class="main-button"
                        >
                            🐾 Pievienot mājdzīvnieku
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
                    Kāpēc šī informācija ir svarīga?
                </h3>

                <p>
                    Jo vairāk informācijas norādīsi par savu mājdzīvnieku,
                    jo vieglāk pieskatītājam būs sagatavoties tā aprūpei.
                </p>


                <div class="pet-form-tip">

                    <span>✓</span>

                    <p>
                        Norādi pareizu dzīvnieka veidu un šķirni.
                    </p>

                </div>


                <div class="pet-form-tip">

                    <span>✓</span>

                    <p>
                        Pievieno informāciju par īpašām aprūpes prasībām.
                    </p>

                </div>


                <div class="pet-form-tip">

                    <span>✓</span>

                    <p>
                        Attēli palīdz pieskatītājam iepazīt tavu mīluli.
                    </p>

                </div>


                <div class="pet-form-tip">

                    <span>✓</span>

                    <p>
                        Vari pievienot līdz pieciem mājdzīvnieka attēliem.
                    </p>

                </div>

            </aside>

        </section>

    </main>


    <script>

        const imageInput = document.getElementById('images');
        const imagePreview = document.getElementById('image-preview');
        const imageCounter = document.getElementById('image-counter');

        let selectedFiles = [];


        imageInput.addEventListener('change', function () {

            const newFiles = Array.from(this.files);

            if (selectedFiles.length + newFiles.length > 5) {

                alert('Vienam mājdzīvniekam var pievienot ne vairāk kā 5 bildes.');

                this.value = '';

                return;
            }


            selectedFiles = [
                ...selectedFiles,
                ...newFiles
            ];


            updateFiles();
            updatePreview();

        });


        function updateFiles() {

            const dataTransfer = new DataTransfer();


            selectedFiles.forEach(function (file) {

                dataTransfer.items.add(file);

            });


            imageInput.files = dataTransfer.files;

        }


        function updatePreview() {

            imagePreview.innerHTML = '';

            imageCounter.textContent =
                selectedFiles.length + ' / 5';


            selectedFiles.forEach(function (file, index) {

                const reader = new FileReader();


                reader.onload = function (event) {

                    const wrapper = document.createElement('div');

                    wrapper.className = 'image-preview-item';


                    const image = document.createElement('img');

                    image.src = event.target.result;
                    image.alt = 'Mājdzīvnieka attēls';


                    const removeButton = document.createElement('button');

                    removeButton.type = 'button';
                    removeButton.className = 'remove-image';
                    removeButton.textContent = '×';
                    removeButton.setAttribute(
                        'aria-label',
                        'Noņemt attēlu'
                    );


                    removeButton.addEventListener('click', function () {

                        removeImage(index);

                    });


                    wrapper.appendChild(image);
                    wrapper.appendChild(removeButton);

                    imagePreview.appendChild(wrapper);

                };


                reader.readAsDataURL(file);

            });

        }


        function removeImage(index) {

            selectedFiles.splice(index, 1);

            updateFiles();
            updatePreview();

        }

    </script>

</body>
</html>