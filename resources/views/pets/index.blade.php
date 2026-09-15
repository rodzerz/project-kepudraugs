```blade
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mani mājdzīvnieki - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        .pet-images {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .pet-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .no-image {
            background: var(--primary-light);
            border-radius: 12px;
            height: 160px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 55px;
            margin-bottom: 20px;
        }

        .delete-button {
            width: 100%;
            margin-top: 15px;
            background: var(--danger);
            color: white;
        }

        .delete-button:hover {
            background: #a94444;
        }

        @media (max-width: 500px) {
            .pet-images {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <x-owner-nav />

    <main class="page-container">

        <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 30px;">

            <div>
                <p class="subtitle">🐾 Tavi draugi</p>

                <h1 class="page-title">
                    Mani mājdzīvnieki
                </h1>

                <p class="page-description">
                    Šeit vari apskatīt un pārvaldīt savus pievienotos mājdzīvniekus.
                </p>
            </div>

            <a href="/pets/create" class="main-button">
                + Pievienot mājdzīvnieku
            </a>

        </div>

        @if (session('success'))

            <div class="alert alert-success">
                <strong>{{ session('success') }}</strong>
            </div>

        @endif

        @if ($pets->count() > 0)

            <div class="features">

                @foreach ($pets as $pet)

                    <div class="feature">

                        @if ($pet->images->count() > 0)

                            <div class="pet-images">

                                @foreach ($pet->images as $image)

                                    <img
                                        src="{{ asset('storage/' . $image->image) }}"
                                        alt="{{ $pet->name }}"
                                        class="pet-image"
                                    >

                                @endforeach

                            </div>

                        @else

                            <div class="no-image">
                                🐾
                            </div>

                        @endif

                        <h3>
                            {{ $pet->name }}
                        </h3>

                        <p>
                            <strong>Veids:</strong><br>
                            {{ $pet->species }}
                        </p>

                        <p>
                            <strong>Šķirne:</strong><br>
                            {{ $pet->breed ?? 'Nav norādīta' }}
                        </p>

                        <p>
                            <strong>Vecums:</strong><br>
                            {{ $pet->age !== null ? $pet->age . ' gadi' : 'Nav norādīts' }}
                        </p>

                        <p>
                            <strong>Svars:</strong><br>
                            {{ $pet->weight !== null ? $pet->weight . ' kg' : 'Nav norādīts' }}
                        </p>

                        <p>
                            <strong>Īpašās prasības:</strong><br>
                            {{ $pet->special_requirements ?? 'Nav norādītas' }}
                        </p>

                        <form
                            action="/pets/{{ $pet->id }}"
                            method="POST"
                            onsubmit="return confirm('Vai tiešām vēlies izdzēst {{ $pet->name }}?');"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="delete-button"
                            >
                                🗑️ Dzēst mājdzīvnieku
                            </button>

                        </form>

                    </div>

                @endforeach

            </div>

        @else

            <div class="card" style="text-align: center;">

                <div class="feature-icon">
                    🐶
                </div>

                <h3>
                    Tev vēl nav pievienotu mājdzīvnieku
                </h3>

                <p class="page-description">
                    Pievieno savu pirmo mājdzīvnieku, lai tā informācija
                    būtu pieejama rezervāciju veikšanai.
                </p>

                <a href="/pets/create" class="main-button">
                    + Pievienot mājdzīvnieku
                </a>

            </div>

        @endif

    </main>

</body>
</html>
```
