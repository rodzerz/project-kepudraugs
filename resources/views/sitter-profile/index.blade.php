<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pieskatītāji - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-owner-nav />

    <main class="page-container">

        <div class="card">

            <p class="subtitle">🐾 Atrodi savu palīgu</p>

            <h1 class="page-title">
                Mājdzīvnieku pieskatītāji
            </h1>

            <p class="page-description">
                Atrodi piemērotu pieskatītāju savam mājdzīvniekam
                pēc pilsētas.
            </p>

            <form method="GET" action="/sitters">

                <div class="form-group">

                    <label for="city">
                        Meklēt pēc pilsētas
                    </label>

                    <input
                        type="text"
                        id="city"
                        name="city"
                        value="{{ request('city') }}"
                        placeholder="Piemēram, Rīga"
                    >

                </div>

                <button type="submit">
                    🔎 Meklēt pieskatītāju
                </button>

            </form>

        </div>

        <br>

        @if ($profiles->count() > 0)

            <div class="features">

                @foreach ($profiles as $profile)

                    <div class="feature">

                        <div class="feature-icon">
                            🐕
                        </div>

                        <h3>
                            {{ $profile->user->name }}
                        </h3>

                        {{-- VĒRTĒJUMS --}}

                        <div style="margin: 10px 0 20px;">

                            @if ($profile->reviews_count > 0)

                                <div style="font-size: 20px;">

                                    @for ($i = 1; $i <= 5; $i++)

                                        @if ($i <= round($profile->average_rating))
                                            ⭐
                                        @else
                                            ☆
                                        @endif

                                    @endfor

                                </div>

                                <strong>
                                    {{ number_format($profile->average_rating, 1) }} / 5
                                </strong>

                                <small style="color: var(--text-light);">
                                    ({{ $profile->reviews_count }}
                                    {{ $profile->reviews_count == 1 ? 'atsauksme' : 'atsauksmes' }})
                                </small>

                            @else

                                <span style="color: var(--text-light);">
                                    ⭐ Vēl nav vērtējumu
                                </span>

                            @endif

                        </div>

                        <p>
                            <strong>📍 Pilsēta:</strong><br>
                            {{ $profile->city }}
                        </p>

                        <p>
                            <strong>💬 Par sevi:</strong><br>
                            {{ $profile->description ?? 'Nav norādīts' }}
                        </p>

                        <p>
                            <strong>⭐ Pieredze:</strong><br>
                            {{ $profile->experience ?? 'Nav norādīta' }}
                        </p>

                        <p>
                            <strong>💶 Cena:</strong><br>
                            {{ $profile->price }} € / dienā
                        </p>

                        <p>
                            <strong>🐾 Pieskatāmie dzīvnieki:</strong><br>
                            {{ $profile->accepted_animals }}
                        </p>

                        <br>

                        <a
                            href="/bookings/create/{{ $profile->id }}"
                            class="main-button"
                        >
                            Veikt rezervāciju
                        </a>

                    </div>

                @endforeach

            </div>

        @else

            <div class="card" style="text-align: center;">

                <div class="feature-icon">
                    🔎
                </div>

                <h3>
                    Pieskatītāji nav atrasti
                </h3>

                <p class="page-description">
                    Šobrīd pēc norādītajiem kritērijiem
                    nav pieejamu pieskatītāju.
                </p>

            </div>

        @endif

    </main>

</body>
</html>