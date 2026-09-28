<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sarakste - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    @if (auth()->user()->role === 'owner')

        <x-owner-nav />

    @else

        <x-sitter-nav />

    @endif


    <main class="page-container">

        <div class="conversation">

            <!-- LAPAS GALVENE -->

            <section class="conversation-header">

                <div>

                    <p class="section-label">
                        Rezervācijas sarakste
                    </p>

                    <h1 class="page-title">
                        Ziņas
                    </h1>

                    <p class="page-description">
                        Sazinies ar otru rezervācijas dalībnieku un
                        vienojies par svarīgāko informāciju.
                    </p>

                </div>


                @if (auth()->user()->role === 'owner')

                    <a
                        href="/bookings"
                        class="secondary-button"
                    >
                        ← Atpakaļ
                    </a>

                @else

                    <a
                        href="/bookings/sitter"
                        class="secondary-button"
                    >
                        ← Atpakaļ
                    </a>

                @endif

            </section>


            <!-- REZERVĀCIJAS INFORMĀCIJA -->

            <section class="conversation-booking-card">

                <div class="conversation-booking-heading">

                    <div class="conversation-booking-icon">
                        🐾
                    </div>

                    <div>

                        <span>
                            Sarakste par rezervāciju
                        </span>

                        <strong>
                            {{ $booking->pet_type }}
                        </strong>

                    </div>

                </div>


                <div class="conversation-booking-details">

                    <div class="conversation-booking-detail">

                        <span class="conversation-detail-icon">
                            📅
                        </span>

                        <div>

                            <span>
                                Datums
                            </span>

                            <strong>
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y.') }}
                            </strong>

                        </div>

                    </div>


                    <div class="conversation-booking-detail">

                        <span class="conversation-detail-icon">
                            🕐
                        </span>

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

            </section>


            <!-- SARAKSTE -->

            <section class="conversation-card">

                <div class="conversation-card-heading">

                    <div>

                        <p class="section-label">
                            Sarakste
                        </p>

                        <h2>
                            Ziņas
                        </h2>

                    </div>

                    <span class="conversation-message-count">
                        {{ $messages->count() }}
                        {{ $messages->count() == 1 ? 'ziņa' : 'ziņas' }}
                    </span>

                </div>


                <!-- ZIŅAS -->

                <div class="messages">

                    @forelse ($messages as $message)

                        @if ($message->sender_id === auth()->id())

                            <!-- NOSŪTĪTĀ ZIŅA -->

                            <div class="message-row message-row-sent">

                                <div class="message message-sent">

                                    <div class="message-name">
                                        Tu
                                    </div>

                                    <p class="message-text">
                                        {{ $message->message }}
                                    </p>

                                    <span class="message-time">
                                        {{ $message->created_at->format('d.m.Y. H:i') }}
                                    </span>

                                </div>

                            </div>

                        @else

                            <!-- SAŅEMTĀ ZIŅA -->

                            <div class="message-row message-row-received">

                                <div class="message-avatar">
                                    {{ mb_strtoupper(mb_substr($message->sender->name, 0, 1)) }}
                                </div>


                                <div class="message message-received">

                                    <div class="message-name">
                                        {{ $message->sender->name }}
                                    </div>

                                    <p class="message-text">
                                        {{ $message->message }}
                                    </p>

                                    <span class="message-time">
                                        {{ $message->created_at->format('d.m.Y. H:i') }}
                                    </span>

                                </div>

                            </div>

                        @endif


                    @empty

                        <!-- NAV ZIŅU -->

                        <div class="conversation-empty">

                            <div class="conversation-empty-icon">
                                💬
                            </div>

                            <h3>
                                Sarakste vēl nav sākta
                            </h3>

                            <p>
                                Nosūti pirmo ziņu, lai vienotos par
                                rezervācijas detaļām.
                            </p>

                        </div>

                    @endforelse

                </div>


                <!-- ZIŅAS NOSŪTĪŠANA -->

                <div class="message-compose">

                    <form
                        action="/bookings/{{ $booking->id }}/messages"
                        method="POST"
                        class="message-form"
                    >

                        @csrf


                        <div class="message-input-wrapper">

                            <label for="message">
                                Tava ziņa
                            </label>

                            <textarea
                                id="message"
                                name="message"
                                placeholder="Uzraksti ziņu..."
                                required
                            >{{ old('message') }}</textarea>


                            @error('message')

                                <p class="field-error">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        <button
                            type="submit"
                            class="message-send-button"
                        >
                            <span>
                                Nosūtīt
                            </span>

                            <span>
                                ➜
                            </span>
                        </button>

                    </form>

                </div>

            </section>

        </div>

    </main>

</body>
</html>