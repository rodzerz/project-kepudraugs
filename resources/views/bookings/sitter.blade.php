```blade
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Saņemtās rezervācijas - ĶepuDraugs.lv</title>
</head>

<body>

    <x-sitter-nav />

    <h2>Saņemtās rezervācijas</h2>

    @if (session('success'))
        <p>
            <strong>{{ session('success') }}</strong>
        </p>
    @endif

    @if ($bookings->count() > 0)

        @foreach ($bookings as $booking)

            <div>

                <h3>
                    Īpašnieks: {{ $booking->owner->name }}
                </h3>

                <p>
                    <strong>Mājdzīvnieka veids:</strong>
                    {{ $booking->pet_type }}
                </p>

                <p>
                    <strong>Datums:</strong>
                    {{ $booking->booking_date }}
                </p>

                <p>
                    <strong>Laiks:</strong>
                    {{ $booking->start_time }} - {{ $booking->end_time }}
                </p>

                <p>
                    <strong>Ziņa:</strong>
                    {{ $booking->message ?? 'Nav ziņas' }}
                </p>

                <p>
                    <strong>Statuss:</strong>
                    {{ $booking->status }}
                </p>

                @if ($booking->status === 'pending')

                    <form action="/bookings/{{ $booking->id }}/accept" method="POST">
                        @csrf

                        <button type="submit">
                            Pieņemt
                        </button>
                    </form>

                    <br>

                    <form action="/bookings/{{ $booking->id }}/reject" method="POST">
                        @csrf

                        <button type="submit">
                            Noraidīt
                        </button>
                    </form>

                @endif

            </div>

            <hr>

        @endforeach

    @else

        <p>Tev vēl nav saņemtu rezervāciju.</p>

    @endif

</body>
</html>
```
