```blade
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mans profils - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    @if ($user->role === 'owner')

        <x-owner-nav />

    @elseif ($user->role === 'sitter')

        <x-sitter-nav />

    @endif

    <main class="page-container">

        <div class="form-container">

            <div class="card">

                <div style="text-align: center;">

                    <div class="feature-icon">
                        👤
                    </div>

                    <p class="subtitle">
                        🐾 ĶepuDraugs.lv
                    </p>

                    <h1 class="page-title">
                        Mans profils
                    </h1>

                    <p class="page-description">
                        Tava konta pamatinformācija.
                    </p>

                </div>

                @if (session('success'))

                    <div class="alert alert-success">
                        <strong>{{ session('success') }}</strong>
                    </div>

                @endif

                <div style="margin-top: 30px;">

                    <p>
                        <strong>👤 Vārds</strong><br>
                        {{ $user->name }}
                    </p>

                    <p>
                        <strong>✉️ E-pasts</strong><br>
                        {{ $user->email }}
                    </p>

                    <p>
                        <strong>🐾 Lietotāja veids</strong><br>

                        @if ($user->role === 'owner')
                            Mājdzīvnieka īpašnieks
                        @elseif ($user->role === 'sitter')
                            Mājdzīvnieku pieskatītājs
                        @endif
                    </p>

                </div>

                <div style="margin-top: 30px;">

                    <a href="/profile/edit" class="main-button">
                        ✏️ Rediģēt profilu
                    </a>

                </div>

            </div>

        </div>

    </main>

</body>
</html>
```
