```blade id="k3m8qa"
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mans pieskatītāja profils - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

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

        </div>

    </main>

</body>
</html>
```
