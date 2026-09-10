```blade
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rezervācija - ĶepuDraugs.lv</title>
</head>

<body>

    <h1>🐾 ĶepuDraugs.lv</h1>

    <h2>Izveidot rezervāciju</h2>

    @if ($errors->any())
        <div>
            <strong>Radās kļūda:</strong>

            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <h3>Pieskatītājs: {{ $sitterProfile->user->name }}</h3>

    <p>
        <strong>Pilsēta:</strong>
        {{ $sitterProfile->city }}
    </p>

    <p>
        <strong>Cena:</strong>
        {{ $sitterProfile->price }} € / dienā
    </p>

    <form method="POST" action="/bookings">

        @csrf

        <input
            type="hidden"
            name="sitter_id"
            value="{{ $sitterProfile->user_id }}"
        >

        <div>
            <label>Mājdzīvnieka veids</label>
            <br>

            <input
                type="text"
                name="pet_type"
                value="{{ old('pet_type') }}"
                placeholder="Piemēram, suns, kaķis, papagailis"
                required
            >
        </div>

        <br>

        <div>
            <label>Datums</label>
            <br>

            <input
                type="date"
                name="booking_date"
                value="{{ old('booking_date') }}"
                required
            >
        </div>

        <br>

        <div>
            <label>No</label>
            <br>

            <input
                type="time"
                name="start_time"
                value="{{ old('start_time') }}"
                required
            >
        </div>

        <br>

        <div>
            <label>Līdz</label>
            <br>

            <input
                type="time"
                name="end_time"
                value="{{ old('end_time') }}"
                required
            >
        </div>

        <br>

        <div>
            <label>Ziņa pieskatītājam</label>
            <br>

            <textarea
                name="message"
                rows="5"
                cols="40"
                placeholder="Uzraksti pieskatītājam svarīgu informāciju..."
            >{{ old('message') }}</textarea>
        </div>

        <br>

        <button type="submit">
            Nosūtīt rezervācijas pieprasījumu
        </button>

    </form>

    <br>

    <a href="/sitters">Atpakaļ pie pieskatītājiem</a>

</body>
</html>
```
