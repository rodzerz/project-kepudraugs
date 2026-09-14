<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pieskatītāji - ĶepuDraugs.lv</title>
</head>

<body>

    <x-owner-nav />

    <h2>Mājdzīvnieku pieskatītāji</h2>

    <form method="GET" action="/sitters">

        <label>Meklēt pēc pilsētas:</label>

        <input
            type="text"
            name="city"
            value="{{ request('city') }}"
            placeholder="Piemēram, Rīga"
        >

        <button type="submit">Meklēt</button>

    </form>

    <br>

    @if ($profiles->count() > 0)

        @foreach ($profiles as $profile)

            <div>
                <h3>{{ $profile->user->name }}</h3>

                <p>
                    <strong>Pilsēta:</strong>
                    {{ $profile->city }}
                </p>

                <p>
                    <strong>Par sevi:</strong>
                    {{ $profile->description ?? 'Nav norādīts' }}
                </p>

                <p>
                    <strong>Pieredze:</strong>
                    {{ $profile->experience ?? 'Nav norādīta' }}
                </p>

                <p>
                    <strong>Cena:</strong>
                    {{ $profile->price }} € / dienā
                </p>

                <p>
                    <strong>Pieskatāmie dzīvnieki:</strong>
                    {{ $profile->accepted_animals }}
                </p>

                <br>

                <a href="/bookings/create/{{ $profile->id }}">
                    Veikt rezervāciju
                </a>
            </div>

            <hr>

        @endforeach

    @else

        <p>Šobrīd nav pieejamu pieskatītāju.</p>

    @endif

</body>
</html>