```blade
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Saņemtās rezervācijas - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        .message-button {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .unread-badge {
            position: absolute;
            top: -8px;
            right: -8px;

            min-width: 22px;
            height: 22px;

            padding: 0 6px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--danger);
            color: white;

            border-radius: 50%;

            font-size: 12px;
            font-weight: 700;
            line-height: 1;

            border: 2px solid var(--white);
        }
    </style>
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

                @php
                    $unreadMessages = $booking->messages()
                        ->where('receiver_id', auth()->id())
                        ->whereNull('read_at')
                        ->count();
                @endphp

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

                        @elseif ($booking->status === 'completed')

                            <span class="status status-accepted">
                                Pabeigta
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

                    <div style="display: flex; gap: 12px; margin-top: 25px; flex-wrap: wrap;">

                        <a
                            href="/bookings/{{ $booking->id }}/messages"
                            class="main-button message-button"
                        >
                            💬 Sarakste

                            @if ($unreadMessages > 0)

                                <span class="unread-badge">
                                    {{ $unreadMessages }}
                                </span>

                            @endif

                        </a>

                        @if ($booking->status === 'pending')

                            <form
                                action="/bookings/{{ $booking->id }}/accept"
                                method="POST"
                                style="margin: 0;"
                            >

                                @csrf

                                <button type="submit">
                                    ✓ Pieņemt
                                </button>

                            </form>

                            <form
                                action="/bookings/{{ $booking->id }}/reject"
                                method="POST"
                                style="margin: 0;"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    style="background: var(--danger);"
                                >
                                    ✕ Noraidīt
                                </button>

                            </form>

                        @elseif ($booking->status === 'accepted')

                            <form
                                action="/bookings/{{ $booking->id }}/complete"
                                method="POST"
                                style="margin: 0;"
                            >

                                @csrf

                                <button type="submit">
                                    ✓ Atzīmēt kā pabeigtu
                                </button>

                            </form>

                        @endif

                    </div>

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
