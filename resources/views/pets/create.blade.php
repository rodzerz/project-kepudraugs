
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pievienot mājdzīvnieku - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        .image-preview {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-top: 15px;
        }

        .image-preview-item {
            position: relative;
        }

        .image-preview-item img {
            width: 100%;
            height: 110px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid var(--border);
            display: block;
        }

        .remove-image {
            position: absolute;
            top: 6px;
            right: 6px;

            width: 28px;
            height: 28px;

            padding: 0;

            border-radius: 50%;
            background: var(--danger);
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 18px;
            line-height: 1;

            cursor: pointer;
        }

        .remove-image:hover {
            background: #a94444;
        }

        .image-counter {
            display: block;
            margin-top: 8px;
            color: var(--text-light);
            font-size: 14px;
        }

        @media (max-width: 700px) {
            .image-preview {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>

    <x-owner-nav />

    <main class="page-container">

        <div class="form-container">

            <div class="card">

                <p class="subtitle">🐾 Tavs jaunais draugs</p>

                <h1 class="page-title">
                    Pievienot mājdzīvnieku
                </h1>

                <p class="page-description">
                    Ievadi informāciju par savu mājdzīvnieku.
                </p>

                @if ($errors->any())

                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>

                @endif

                <form
                    action="/pets"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf

                    <div class="form-group">

                        <label for="name">
                            Mājdzīvnieka vārds
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
                            Dzīvnieka veids
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

                    </div>

                    <div class="form-group">

                        <label for="age">
                            Vecums
                        </label>

                        <input
                            type="number"
                            id="age"
                            name="age"
                            value="{{ old('age') }}"
                            min="0"
                            placeholder="Piemēram, 3"
                        >

                    </div>

                    <div class="form-group">

                        <label for="weight">
                            Svars (kg)
                        </label>

                        <input
                            type="number"
                            id="weight"
                            name="weight"
                            value="{{ old('weight') }}"
                            min="0"
                            step="0.01"
                            placeholder="Piemēram, 12.5"
                        >

                    </div>

                    <div class="form-group">

                        <label for="special_requirements">
                            Īpašās prasības
                        </label>

                        <textarea
                            id="special_requirements"
                            name="special_requirements"
                            placeholder="Norādi svarīgu informāciju par mājdzīvnieku..."
                        >{{ old('special_requirements') }}</textarea>

                    </div>

                    <div class="form-group">

                        <label for="images">
                            Mājdzīvnieka bildes
                        </label>

                        <input
                            type="file"
                            id="images"
                            name="images[]"
                            accept="image/jpeg,image/png,image/webp"
                            multiple
                        >

                        <small>
                            Vari pievienot līdz 5 bildēm. Bildes nav obligātas.
                        </small>

                        <span
                            id="image-counter"
                            class="image-counter"
                        >
                            Izvēlētas bildes: 0 / 5
                        </span>

                        <div
                            id="image-preview"
                            class="image-preview"
                        ></div>

                    </div>

                    <button type="submit">
                        🐾 Pievienot mājdzīvnieku
                    </button>

                </form>

                <br>

                <a href="/pets" class="secondary-button">
                    Atpakaļ uz mājdzīvniekiem
                </a>

            </div>

        </div>

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
                'Izvēlētas bildes: ' +
                selectedFiles.length +
                ' / 5';

            selectedFiles.forEach(function (file, index) {

                const reader = new FileReader();

                reader.onload = function (event) {

                    const wrapper = document.createElement('div');

                    wrapper.className = 'image-preview-item';

                    const image = document.createElement('img');

                    image.src = event.target.result;
                    image.alt = 'Mājdzīvnieka bilde';

                    const removeButton = document.createElement('button');

                    removeButton.type = 'button';
                    removeButton.className = 'remove-image';
                    removeButton.textContent = '×';

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
