<!DOCTYPE html>

<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

```
<title>Mans pieskatītāja profils - ĶepuDraugs.lv</title>

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
```

</head>

<body>

```
<x-sitter-nav />

<main class="page-container">

    <div class="form-container">

        <div class="card">

            <div style="text-align: center;">

                <div class="feature-icon">
                    🐕
                </div>

                <p class="subtitle">
                    🐾 ĶepuDraugs.lv
                </p>

                <h1 class="page-title">
                    Mans pieskatītāja profils
                </h1>

                <p class="page-description">
                    Šo informāciju redz mājdzīvnieku īpašnieki,
                    kuri meklē pieskatītāju.
                </p>

            </div>

            <div style="margin-top: 30px;">

                <p>
                    <strong>👤 Vārds</strong><br>
                    {{ $profile->user->name }}
                </p>

                <p>
                    <strong>📍 Pilsēta</strong><br>
                    {{ $profile->city }}
                </p>

                <p>
                    <strong>💬 Par sevi</strong><br>
                    {{ $profile->description ?? 'Nav norādīts' }}
                </p>

                <p>
                    <strong>⭐ Pieredze</strong><br>
                    {{ $profile->experience ?? 'Nav norādīta' }}
                </p>

                <p>
                    <strong>💶 Cena</strong><br>
                    {{ $profile->price }} € / dienā
                </p>

                <p>
                    <strong>🐾 Pieskatāmie dzīvnieki</strong><br>
                    {{ $profile->accepted_animals }}
                </p>

            </div>

            <div style="margin-top: 30px;">

                <a href="/sitter-profile/create" class="main-button">
                    ✏️ Rediģēt profilu
                </a>

            </div>

        </div>


        {{-- VĒRTĒJUMS --}}

        <div class="card" style="margin-top: 25px; text-align: center;">

            <p class="subtitle">
                ⭐ Vērtējums
            </p>

            @if ($reviews->count() > 0)

                <h2 style="font-size: 36px; margin: 10px 0;">
                    {{ number_format($averageRating, 1) }} / 5
                </h2>

                <p style="font-size: 24px; margin: 5px 0;">
                    @for ($i = 1; $i <= 5; $i++)

                        @if ($i <= round($averageRating))
                            ⭐
                        @else
                            ☆
                        @endif

                    @endfor
                </p>

                <p class="page-description">
                    Balstīts uz {{ $reviews->count() }}
                    {{ $reviews->count() == 1 ? 'atsauksmi' : 'atsauksmēm' }}
                </p>

            @else

                <p class="page-description">
                    Šim pieskatītājam vēl nav nevienas atsauksmes.
                </p>

            @endif

        </div>


        {{-- ATSAUKSMES --}}

        <div class="card" style="margin-top: 25px;">

            <p class="subtitle">
                💬 Atsauksmes
            </p>

            <h2>
                Ko saka mājdzīvnieku īpašnieki?
            </h2>

            @if ($reviews->count() > 0)

                @foreach ($reviews as $review)

                    <div
                        style="
                            padding: 20px 0;
                            border-bottom: 1px solid var(--border);
                        "
                    >

                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap;">

                            <strong>
                                👤 {{ $review->owner->name }}
                            </strong>

                            <span style="font-size: 20px;">

                                @for ($i = 1; $i <= 5; $i++)

                                    @if ($i <= $review->rating)
                                        ⭐
                                    @else
                                        ☆
                                    @endif

                                @endfor

                            </span>

                        </div>

                        @if ($review->review)

                            <p style="margin-top: 12px;">
                                {{ $review->review }}
                            </p>

                        @else

                            <p
                                style="
                                    margin-top: 12px;
                                    color: var(--text-light);
                                "
                            >
                                Atsauksmes teksts nav pievienots.
                            </p>

                        @endif

                        <small style="color: var(--text-light);">
                            {{ $review->created_at->format('d.m.Y.') }}
                        </small>

                    </div>

                @endforeach

            @else

                <p class="page-description">
                    Pagaidām nav nevienas atsauksmes.
                </p>

            @endif

        </div>

    </div>

</main>
```

</body>
</html>
