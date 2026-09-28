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

        <!-- LAPAS GALVENE -->

        <section class="bookings-page-header">

            <div>

                <p class="section-label">
                    Pieskatīšanas pieprasījumi
                </p>

                <h1 class="page-title">
                    Saņemtās rezervācijas
                </h1>

                <p class="page-description">
                    Apskati mājdzīvnieku īpašnieku nosūtītos
                    rezervāciju pieprasījumus un pārvaldi to statusus.
                </p>

            </div>

            <div class="bookings-header-icon">
                📋
            </div>

        </section>


        <!-- PAZIŅOJUMS -->

        @if (session('success'))

            <div class="alert alert-success">
                <strong>{{ session('success') }}</strong>
            </div>

        @endif


        @if ($bookings->count() > 0)

            <!-- REZERVĀCIJU SARAKSTS -->

            <section class="bookings-list">

                @foreach ($bookings as $booking)

                    @php
                        $unreadMessages = $booking->messages()
                            ->where('receiver_id', auth()->id())
                            ->whereNull('read_at')
                            ->count();
                    @endphp


                    <article class="booking-card">

                        <!-- KARTĪTES GALVENE -->

                        <div class="booking-card-header">

                            <div class="booking-person">

                                <div class="booking-person-avatar">
                                    {{ mb_strtoupper(mb_substr($booking->owner->name, 0, 1)) }}
                                </div>

                                <div>

                                    <span class="booking-person-label">
                                        Mājdzīvnieka īpašnieks
                                    </span>

                                    <h2>
                                        {{ $booking->owner->name }}
                                    </h2>

                                </div>

                            </div>


                            <div class="booking-status-wrapper">

                                @if ($booking->status === 'pending')

                                    <span class="status status-pending">
                                        Gaida tavu atbildi
                                    </span>

                                @elseif ($booking->status === 'accepted')

                                    <span class="status status-accepted">
                                        Pieņemta
                                    </span>

                                @elseif ($booking->status === 'completed')

                                    <span class="status status-completed">
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

                        </div>


                        <!-- REZERVĀCIJAS INFORMĀCIJA -->

                        <div class="booking-details-grid">

                            <div class="booking-detail-item">

                                <div class="booking-detail-icon">
                                    🐕
                                </div>

                                <div>

                                    <span>
                                        Mājdzīvnieka veids
                                    </span>

                                    <strong>
                                        {{ $booking->pet_type }}
                                    </strong>

                                </div>

                            </div>


                            <div class="booking-detail-item">

                                <div class="booking-detail-icon">
                                    📅
                                </div>

                                <div>

                                    <span>
                                        Datums
                                    </span>

                                    <strong>
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y.') }}
                                    </strong>

                                </div>

                            </div>


                            <div class="booking-detail-item">

                                <div class="booking-detail-icon">
                                    🕐
                                </div>

                                <div>

                                    <span>
                                        Laiks
                                    </span>

                                    <strong>
                                        {{ substr($booking->start_time, 0, 5) }}
                                        –
                                        {{ substr($booking->end_time, 0, 5) }}
                                    </strong>

                                </div>

                            </div>

                        </div>


                        <!-- ĪPAŠNIEKA ZIŅA -->

                        <div class="booking-message-box">

                            <div class="booking-message-heading">

                                <span>
                                    💬
                                </span>

                                <strong>
                                    Ziņa no īpašnieka
                                </strong>

                            </div>

                            @if ($booking->message)

                                <p>
                                    {{ $booking->message }}
                                </p>

                            @else

                                <p class="booking-no-message">
                                    Īpašnieks nav pievienojis papildu ziņu.
                                </p>

                            @endif

                        </div>


                        <!-- DARBĪBAS -->

                        <div class="booking-card-actions">

                            <a
                                href="/bookings/{{ $booking->id }}/messages"
                                class="secondary-button message-button"
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
                                    class="booking-action-form"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="main-button"
                                    >
                                        ✓ Pieņemt
                                    </button>

                                </form>


                                <form
                                    action="/bookings/{{ $booking->id }}/reject"
                                    method="POST"
                                    class="booking-action-form"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="danger-button"
                                    >
                                        ✕ Noraidīt
                                    </button>

                                </form>


                            @elseif ($booking->status === 'accepted')

                                <form
                                    action="/bookings/{{ $booking->id }}/complete"
                                    method="POST"
                                    class="booking-action-form"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="main-button"
                                    >
                                        ✓ Atzīmēt kā pabeigtu
                                    </button>

                                </form>

                            @endif

                        </div>

                    </article>

                @endforeach

            </section>


        @else

            <!-- TUKŠS STĀVOKLIS -->

            <section class="bookings-empty-state">

                <div class="empty-state-icon">
                    📭
                </div>

                <h2>
                    Tev vēl nav saņemtu rezervāciju
                </h2>

                <p>
                    Kad kāds mājdzīvnieka īpašnieks nosūtīs
                    rezervācijas pieprasījumu, tas parādīsies šeit.
                </p>

            </section>

        @endif

    </main>

</body>
</html>