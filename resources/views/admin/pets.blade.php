<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mājdzīvnieku pārvaldība | ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        .admin-pets-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .admin-pets-header {
            margin-bottom: 25px;
        }

        .admin-pets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .admin-pet-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            box-shadow: var(--shadow);
        }

        .admin-pet-card h2 {
            margin-top: 0;
            color: var(--primary);
        }

        .admin-pet-info {
            margin-bottom: 15px;
        }

        .admin-pet-info p {
            margin: 7px 0;
        }

        .admin-pet-images {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 15px 0;
        }

        .admin-pet-images img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid var(--border);
        }

        .delete-pet-button {
            background: var(--danger);
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .delete-pet-button:hover {
            opacity: 0.9;
        }

        .no-pets {
            background: var(--white);
            padding: 25px;
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        .success-message {
            background: var(--primary-light);
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<nav>
    <div>
        <a href="/admin">🐾 ĶepuDraugs.lv — Administrators</a>
    </div>

    <div>
        <a href="/admin">👥 Lietotāji</a>
        <a href="/admin/bookings">📅 Rezervācijas</a>
        <a href="/admin/pets">🐕 Mājdzīvnieki</a>

        <form action="/logout" method="POST" style="display: inline;">
            @csrf
            <button type="submit">Iziet</button>
        </form>
    </div>
</nav>

<hr>

<div class="admin-pets-container">

    <div class="admin-pets-header">
        <h1>🐕 Mājdzīvnieku pārvaldība</h1>

        <p>
            Šeit administrators var apskatīt lietotāju pievienotos
            mājdzīvniekus un noņemt neatbilstošu saturu.
        </p>
    </div>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if($pets->count() > 0)

        <div class="admin-pets-grid">

            @foreach($pets as $pet)

                <div class="admin-pet-card">

                    <h2>🐾 {{ $pet->name }}</h2>

                    <div class="admin-pet-info">

                        <p>
                            <strong>Īpašnieks:</strong>
                            {{ $pet->user->name }}
                        </p>

                        <p>
                            <strong>Dzīvnieka veids:</strong>
                            {{ $pet->species }}
                        </p>

                        @if($pet->breed)
                            <p>
                                <strong>Šķirne:</strong>
                                {{ $pet->breed }}
                            </p>
                        @endif

                        @if($pet->age)
                            <p>
                                <strong>Vecums:</strong>
                                {{ $pet->age }}
                            </p>
                        @endif

                        @if($pet->weight)
                            <p>
                                <strong>Svars:</strong>
                                {{ $pet->weight }} kg
                            </p>
                        @endif

                        @if($pet->special_requirements)
                            <p>
                                <strong>Īpašās prasības:</strong>
                                {{ $pet->special_requirements }}
                            </p>
                        @endif

                    </div>

                    @if($pet->images->count() > 0)

                        <div class="admin-pet-images">

                            @foreach($pet->images as $image)

                                <img
                                    src="{{ asset('storage/' . $image->image) }}"
                                    alt="{{ $pet->name }}"
                                >

                            @endforeach

                        </div>

                    @else

                        <p>Nav pievienotu attēlu.</p>

                    @endif

                    <form
                        action="/admin/pets/{{ $pet->id }}"
                        method="POST"
                        onsubmit="return confirm('Vai tiešām vēlaties noņemt šo mājdzīvnieku un tā saturu?');"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="delete-pet-button"
                        >
                            🗑️ Noņemt mājdzīvnieku
                        </button>

                    </form>

                </div>

            @endforeach

        </div>

    @else

        <div class="no-pets">
            <p>Sistēmā pašlaik nav pievienotu mājdzīvnieku.</p>
        </div>

    @endif

</div>

</body>
</html>