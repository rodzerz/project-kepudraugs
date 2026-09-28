<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manas rezervācijas - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-owner-nav />

    <main class="page-container">

        <!-- LAPAS GALVENE -->

        <section class="bookings-page-header">

            <div>

                <p class="section-label">
                    Tavas rezervācijas
                </p>

                <h1 class="page-title">
                    Manas rezervācijas
                </h1>

                <p class="page-description">
                    Apskati savus rezervāciju pieprasījumus,
                    to statusus un sazinies ar pieskatītājiem.
                </p>

            </div>

            <a
                href="/sitters"
                class="main-button"
            >
                🔎 Atrast pieskatītāju
            </a>

        </section>


        <!-- PAZIŅOJUMS -->

        @if (session('success'))

            <div class="alert alert-success">
                <strong>{{ session('success') }}</strong>
            </div>

        @endif


        @if ($bookings->count() > 0)

            <section class="bookings-list">

                @foreach ($bookings as $booking)

                    @php
                        $unreadMessages = $booking->messages()
                            ->where('receiver_id', auth()->id())
                            ->whereNull('read_at')
                            ->count();

                        $hasReview = $booking->review()->exists();
                    @endphp


                    <article class="booking-card">

                        <!-- KARTĪTES GALVENE -->

                        <div class="booking-card-header">

                            <div class="booking-person">

                                <div class="booking-person-avatar">
                                    {{ mb_strtoupper(mb_substr($booking->sitter->name, 0, 1)) }}
                                </div>

                                <div>

                                    <span class="booking-person-label">
                                        Pieskatītājs
                                    </span>

                                    <h2>
                                        {{ $booking->sitter->name }}
                                    </h2>

                                </div>

                            </div>


                            <div class="booking-status-wrapper">

                                @if ($booking->status === 'pending')

                                    <span class="status status-pending">
                                        Gaida apstiprinājumu
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


                        <!-- REZERVĀCIJAS ZIŅA -->

                        <div class="booking-message-box">

                            <div class="booking-message-heading">

                                <span>
                                    💬
                                </span>

                                <strong>
                                    Rezervācijas ziņa
                                </strong>

                            </div>


                            @if ($booking->message)

                                <p>
                                    {{ $booking->message }}
                                </p>

                            @else

                                <p class="booking-no-message">
                                    Rezervācijai nav pievienota papildu ziņa.
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
                                    action="/bookings/{{ $booking->id }}/cancel"
                                    method="POST"
                                    class="booking-action-form"
                                    onsubmit="return confirm('Vai tiešām vēlies atcelt šo rezervāciju?');"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="danger-button"
                                    >
                                        ✕ Atcelt rezervāciju
                                    </button>

                                </form>

                            @endif


                            @if ($booking->status === 'completed' && !$hasReview)

                                <a
                                    href="/bookings/{{ $booking->id }}/review"
                                    class="main-button"
                                >
                                    ⭐ Atstāt atsauksmi
                                </a>

                            @elseif ($booking->status === 'completed' && $hasReview)

                                <span class="review-added-badge">
                                    <span>
                                        ⭐
                                    </span>

                                    Atsauksme pievienota
                                </span>

                            @endif

                        </div>

                    </article>

                @endforeach

            </section>


        @else

            <!-- TUKŠS STĀVOKLIS -->

            <section class="bookings-empty-state">

                <div class="empty-state-icon">
                    📅
                </div>

                <h2>
                    Tev vēl nav rezervāciju
                </h2>

                <p>
                    Atrodi piemērotu mājdzīvnieku pieskatītāju
                    un izveido savu pirmo rezervāciju.
                </p>

                <a
                    href="/sitters"
                    class="main-button"
                >
                    🔎 Atrast pieskatītāju
                </a>

            </section>

        @endif

    </main>

</body>
</html>