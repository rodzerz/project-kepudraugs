```blade
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manas rezervācijas - ĶepuDraugs.lv</title>
</head>

<body>

    <h1>🐾 ĶepuDraugs.lv</h1>

    <h2>Manas rezervācijas</h2>

    @if ($bookings->count() > 0)

        @foreach ($bookings as $booking)

            <div>

                <h3>
                    Pieskatītājs: {{ $booking->sitter->name }}
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

            </div>

            <hr>

        @endforeach

    @else

        <p>Tev vēl nav nevienas rezervācijas.</p>

    @endif

    <br>

    <a href="/dashboard">Atpakaļ uz paneli</a>

</body>
</html>
```
