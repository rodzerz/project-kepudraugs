<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Atstāt atsauksmi</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<nav>
    <div>
        <a href="/dashboard">🐾 ĶepuDraugs.lv</a>
    </div>

    <div>
        <a href="/dashboard">Sākums</a>
        <a href="/profile">Mans profils</a>
        <a href="/sitters">Pieskatītāji</a>
        <a href="/pets">Mani mājdzīvnieki</a>
        <a href="/bookings">Manas rezervācijas</a>

        <form action="/logout" method="POST" style="display: inline;">
            @csrf
            <button type="submit">Iziet</button>
        </form>
    </div>
</nav>

<div class="container">

    <h1>⭐ Atstāt atsauksmi</h1>

    <div class="card">

        <h2>Pieskatītājs</h2>

        <p>
            <strong>{{ $booking->sitter->name }}</strong>
        </p>

        <p>
            Rezervācijas datums:
            {{ $booking->booking_date }}
        </p>

        <form action="/bookings/{{ $booking->id }}/review" method="POST">
            @csrf

            <div class="form-group">

                <label for="rating">
                    Vērtējums
                </label>

                <select name="rating" id="rating" required>
                    <option value="">Izvēlies vērtējumu</option>
                    <option value="5">⭐⭐⭐⭐⭐ – Lieliski</option>
                    <option value="4">⭐⭐⭐⭐ – Ļoti labi</option>
                    <option value="3">⭐⭐⭐ – Labi</option>
                    <option value="2">⭐⭐ – Vidēji</option>
                    <option value="1">⭐ – Slikti</option>
                </select>

                @error('rating')
                    <p class="error">{{ $message }}</p>
                @enderror

            </div>

            <div class="form-group">

                <label for="review">
                    Atsauksme
                </label>

                <textarea
                    name="review"
                    id="review"
                    rows="6"
                    maxlength="2000"
                    placeholder="Uzraksti savu atsauksmi par pieskatītāju..."
                >{{ old('review') }}</textarea>

                @error('review')
                    <p class="error">{{ $message }}</p>
                @enderror

            </div>

            <button type="submit" class="btn">
                ⭐ Iesniegt atsauksmi
            </button>

            <a href="/bookings" class="btn btn-secondary">
                Atcelt
            </a>

        </form>

    </div>

</div>

</body>
</html>