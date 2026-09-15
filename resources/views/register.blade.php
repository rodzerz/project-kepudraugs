```blade
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reģistrācija - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <main class="page-container">

        <div class="form-container">

            <div class="card">

                <div style="text-align: center;">

                    <div class="feature-icon">
                        🐾
                    </div>

                    <p class="subtitle">
                        ĶepuDraugs.lv
                    </p>

                    <h1 class="page-title">
                        Izveido savu kontu
                    </h1>

                    <p class="page-description">
                        Pievienojies ĶepuDraugs.lv un atrodi piemērotu
                        mājdzīvnieku pieskatīšanas risinājumu.
                    </p>

                </div>

                @if ($errors->any())

                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>

                @endif

                <form action="/register" method="POST">

                    @csrf

                    <div class="form-group">

                        <label for="name">
                            👤 Vārds
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ievadi savu vārdu"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="email">
                            ✉️ E-pasts
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="piemers@epasts.lv"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="password">
                            🔒 Parole
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Vismaz 6 rakstzīmes"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="password_confirmation">
                            🔒 Atkārtota parole
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Atkārto paroli"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="role">
                            🐾 Lietotāja veids
                        </label>

                        <select id="role" name="role" required>

                            <option value="">
                                Izvēlies lietotāja veidu
                            </option>

                            <option
                                value="owner"
                                {{ old('role') === 'owner' ? 'selected' : '' }}
                            >
                                Mājdzīvnieka īpašnieks
                            </option>

                            <option
                                value="sitter"
                                {{ old('role') === 'sitter' ? 'selected' : '' }}
                            >
                                Mājdzīvnieku pieskatītājs
                            </option>

                        </select>

                    </div>

                    <button type="submit">
                        🐾 Reģistrēties
                    </button>

                </form>

                <div style="text-align: center; margin-top: 25px;">

                    <p>
                        Jau ir konts?
                    </p>

                    <a href="/login" class="secondary-button">
                        Ielogoties
                    </a>

                </div>

            </div>

        </div>

    </main>

</body>
</html>
```
