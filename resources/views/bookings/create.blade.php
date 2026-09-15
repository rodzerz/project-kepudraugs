
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Veikt rezervāciju - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-owner-nav />

    <main class="page-container">

        <div class="form-container">

            <div class="card">

                <p class="subtitle">📅 Rezervācija</p>

                <h1 class="page-title">
                    Veikt rezervāciju
                </h1>

                <p class="page-description">
                    Nosūti rezervācijas pieprasījumu pieskatītājam
                    <strong>{{ $sitterProfile->user->name }}</strong>.
                </p>

                <div class="alert alert-warning">
                    <strong>Pieskatītājs:</strong>
                    {{ $sitterProfile->user->name }}
                    <br>

                    <strong>Pilsēta:</strong>
                    {{ $sitterProfile->city }}
                    <br>

                    <strong>Cena:</strong>
                    {{ $sitterProfile->price }} € / dienā
                </div>

                @if ($errors->any())

                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>

                @endif

                <form action="/bookings" method="POST">

                    @csrf

                    <input
                        type="hidden"
                        name="sitter_id"
                        value="{{ $sitterProfile->user_id }}"
                    >

                    <div class="form-group">

                        <label for="pet_type">
                            Mājdzīvnieka veids
                        </label>

                        <input
                            type="text"
                            id="pet_type"
                            name="pet_type"
                            value="{{ old('pet_type') }}"
                            placeholder="Piemēram, Suns"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="booking_date">
                            Datums
                        </label>

                        <input
                            type="date"
                            id="booking_date"
                            name="booking_date"
                            value="{{ old('booking_date') }}"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="start_time">
                            Sākuma laiks
                        </label>

                        <input
                            type="time"
                            id="start_time"
                            name="start_time"
                            value="{{ old('start_time') }}"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="end_time">
                            Beigu laiks
                        </label>

                        <input
                            type="time"
                            id="end_time"
                            name="end_time"
                            value="{{ old('end_time') }}"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="message">
                            Ziņa pieskatītājam
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            placeholder="Piemēram, svarīga informācija par mājdzīvnieku..."
                        >{{ old('message') }}</textarea>

                    </div>

                    <button type="submit">
                        📅 Nosūtīt rezervācijas pieprasījumu
                    </button>

                </form>

                <br>

                <a href="/sitters" class="secondary-button">
                    Atpakaļ uz pieskatītājiem
                </a>

            </div>

        </div>

    </main>

</body>
</html>
```
