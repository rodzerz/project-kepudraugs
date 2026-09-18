<!DOCTYPE html>

<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

```
<title>Manas rezervācijas - ĶepuDraugs.lv</title>

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
```

</head>

<body>

```
<x-owner-nav />

<main class="page-container">

    <div>
        <p class="subtitle">📅 Tavas rezervācijas</p>

        <h1 class="page-title">
            Manas rezervācijas
        </h1>

        <p class="page-description">
            Šeit vari apskatīt savus rezervāciju pieprasījumus
            un to pašreizējo statusu.
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

                $hasReview = $booking->review()->exists();
            @endphp

            <div class="card">

                <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap;">

                    <div>

                        <p class="subtitle">
                            🐾 Pieskatītājs
                        </p>

                        <h3>
                            {{ $booking->sitter->name }}
                        </h3>

                    </div>

                    @if ($booking->status === 'pending')

                        <span class="status status-pending">
                            Gaida apstiprinājumu
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
                    <strong>💬 Ziņa:</strong><br>
                    {{ $booking->message ?? 'Nav ziņas' }}
                </p>

                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 25px;">

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
                            action="/bookings/{{ $booking->id }}/cancel"
                            method="POST"
                            style="margin: 0;"
                        >

                            @csrf

                            <button
                                type="submit"
                                style="background: var(--danger);"
                            >
                                Atcelt rezervāciju
                            </button>

                        </form>

                    @endif

                    @if ($booking->status === 'accepted' && !$hasReview)

                        <a
                            href="/bookings/{{ $booking->id }}/review"
                            class="main-button"
                        >
                            ⭐ Atstāt atsauksmi
                        </a>

                    @elseif ($booking->status === 'accepted' && $hasReview)

                        <span
                            class="status status-accepted"
                            style="display: inline-flex; align-items: center;"
                        >
                            ⭐ Atsauksme pievienota
                        </span>

                    @endif

                </div>

            </div>

        @endforeach

    @else

        <div class="card" style="text-align: center;">

            <div class="feature-icon">
                📅
            </div>

            <h3>
                Tev vēl nav rezervāciju
            </h3>

            <p class="page-description">
                Atrodi piemērotu pieskatītāju un izveido
                savu pirmo rezervāciju.
            </p>

            <a href="/sitters" class="main-button">
                🔎 Atrast pieskatītāju
            </a>

        </div>

    @endif

</main>
```

</body>
</html>
