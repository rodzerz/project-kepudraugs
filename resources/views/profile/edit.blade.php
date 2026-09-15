```blade
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rediģēt profilu - ĶepuDraugs.lv</title>

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
                        ✏️
                    </div>

                    <p class="subtitle">
                        👤 Tavs profils
                    </p>

                    <h1 class="page-title">
                        Rediģēt profilu
                    </h1>

                    <p class="page-description">
                        Maini sava konta pamatinformāciju.
                    </p>

                </div>

                @if ($errors->any())

                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>

                @endif

                <form action="/profile" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="form-group">

                        <label for="name">
                            Vārds
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="email">
                            E-pasts
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                        >

                    </div>

                    <button type="submit">
                        ✓ Saglabāt izmaiņas
                    </button>

                </form>

                <br>

                <a href="/profile" class="secondary-button">
                    Atpakaļ uz profilu
                </a>

            </div>

        </div>

    </main>

</body>
</html>
```
