```blade id="sitter-bookings-page"
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Saņemtās rezervācijas - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-sitter-nav />

    <main class="page-container">

        <div>
            <p class="subtitle">📋 Pieskatīšanas pieprasījumi</p>

            <h1 class="page-title">
                Saņemtās rezervācijas
            </h1>

            <p class="page-description">
                Šeit vari apskatīt mājdzīvnieku īpašnieku
                nosūtītos rezervāciju pieprasījumus.
            </p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <strong>{{ session('success') }}</strong>
            </div>
        @endif

        @if ($bookings->count() > 0)

            @foreach ($bookings as $booking)

                <div class="card">

                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap;">

                        <div>
                            <p class="subtitle">
                                👤 Mājdzīvnieka īpašnieks
                            </p>

                            <h3>
                                {{ $booking->owner->name }}
                            </h3>
                        </div>

                        @if ($booking->status === 'pending')

                            <span class="status status-pending">
                                Gaida tavu atbildi
                            </span>

                        @elseif ($booking->status === 'accepted')

                            <span class="status status-accepted">
                                Pieņemta
                            </span>

                        @elseif ($booking->status === 'rejected')

                            <span class="status status-rejected">
                                Noraidīta
                            </span>

                        @elseif ($booking->status === 'cancelled')

                            <span class="status status-cancelled">
                                Atcelta
                            </span>

                        @endif

                    </div>

                    <hr style="border: none; border-top: 1px solid var(--border); margin: 20px 0;">

                    <p>
                        <strong>🐕 Mājdzīvnieka veids:</strong><br>
                        {{ $booking->pet_type }}
                    </p>

                    <p>
                        <strong>📅 Datums:</strong><br>
                        {{ $booking->booking_date }}
                    </p>

                    <p>
                        <strong>🕐 Laiks:</strong><br>
                        {{ $booking->start_time }} - {{ $booking->end_time }}
                    </p>

                    <p>
                        <strong>💬 Ziņa no īpašnieka:</strong><br>
                        {{ $booking->message ?? 'Nav ziņas' }}
                    </p>

                    @if ($booking->status === 'pending')

                        <div style="display: flex; gap: 12px; margin-top: 25px; flex-wrap: wrap;">

                            <form
                                action="/bookings/{{ $booking->id }}/accept"
                                method="POST"
                            >

                                @csrf

                                <button type="submit">
                                    ✓ Pieņemt
                                </button>

                            </form>

                            <form
                                action="/bookings/{{ $booking->id }}/reject"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    style="background: var(--danger);"
                                >
                                    ✕ Noraidīt
                                </button>

                            </form>

                        </div>

                    @endif

                </div>

            @endforeach

        @else

            <div class="card" style="text-align: center;">

                <div class="feature-icon">
                    📭
                </div>

                <h3>
                    Tev vēl nav saņemtu rezervāciju
                </h3>

                <p class="page-description">
                    Kad kāds mājdzīvnieka īpašnieks nosūtīs
                    rezervācijas pieprasījumu, tas parādīsies šeit.
                </p>

            </div>

        @endif

    </main>

</body>
</html>
```
