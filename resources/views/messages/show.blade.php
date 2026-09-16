<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sarakste - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        .conversation {
            max-width: 800px;
            margin: 0 auto;
        }

        .booking-info {
            margin-bottom: 25px;
        }

        .messages {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 25px;
        }

        .message {
            max-width: 75%;
            padding: 12px 16px;
            border-radius: 14px;
        }

        .message-sent {
            align-self: flex-end;
            background: var(--primary);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message-received {
            align-self: flex-start;
            background: var(--primary-light);
            color: var(--text);
            border-bottom-left-radius: 4px;
        }

        .message-name {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .message-text {
            margin: 0;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .message-time {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            opacity: 0.7;
        }

        .message-form {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }

        .message-form textarea {
            min-height: 80px;
            resize: vertical;
            margin: 0;
        }

        .message-form button {
            width: auto;
            min-width: 150px;
            margin: 0;
        }

        .no-messages {
            text-align: center;
            padding: 30px;
            color: var(--text-light);
            background: var(--primary-light);
            border-radius: 14px;
        }

        @media (max-width: 600px) {
            .message {
                max-width: 90%;
            }

            .message-form {
                flex-direction: column;
                align-items: stretch;
            }

            .message-form button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    @if (auth()->user()->role === 'owner')

        <x-owner-nav />

    @else

        <x-sitter-nav />

    @endif

    <main class="page-container">

        <div class="conversation">

            <div class="card booking-info">

                <p class="subtitle">💬 Sarakste</p>

                <h1 class="page-title">
                    Sarakste par rezervāciju
                </h1>

                <p class="page-description">
                    Šeit vari sazināties ar otru rezervācijas dalībnieku
                    un vienoties par tikšanās vietu, laiku un citu svarīgu informāciju.
                </p>

                <p>
                    <strong>Mājdzīvnieks:</strong>
                    {{ $booking->pet_type }}
                </p>

                <p>
                    <strong>Datums:</strong>
                    {{ $booking->booking_date }}
                </p>

                <p>
                    <strong>Laiks:</strong>
                    {{ $booking->start_time }}–{{ $booking->end_time }}
                </p>

            </div>

            <div class="card">

                <div class="messages">

                    @forelse ($messages as $message)

                        @if ($message->sender_id === auth()->id())

                            <div class="message message-sent">

                                <div class="message-name">
                                    Tu
                                </div>

                                <p class="message-text">
                                    {{ $message->message }}
                                </p>

                                <span class="message-time">
                                    {{ $message->created_at->format('d.m.Y H:i') }}
                                </span>

                            </div>

                        @else

                            <div class="message message-received">

                                <div class="message-name">
                                    {{ $message->sender->name }}
                                </div>

                                <p class="message-text">
                                    {{ $message->message }}
                                </p>

                                <span class="message-time">
                                    {{ $message->created_at->format('d.m.Y H:i') }}
                                </span>

                            </div>

                        @endif

                    @empty

                        <div class="no-messages">
                            💬 Šajā sarakstē vēl nav ziņu.
                        </div>

                    @endforelse

                </div>

                <form
                    action="/bookings/{{ $booking->id }}/messages"
                    method="POST"
                    class="message-form"
                >

                    @csrf

                    <div style="flex: 1;">

                        <label for="message">
                            Tava ziņa
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            placeholder="Uzraksti ziņu..."
                            required
                        ></textarea>

                        @error('message')

                            <p class="alert alert-danger">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    <button type="submit">
                        📤 Nosūtīt
                    </button>

                </form>

            </div>

            <div style="margin-top: 20px;">

                @if (auth()->user()->role === 'owner')

                    <a href="/bookings" class="secondary-button">
                        ← Atpakaļ uz rezervācijām
                    </a>

                @else

                    <a href="/bookings/sitter" class="secondary-button">
                        ← Atpakaļ uz rezervācijām
                    </a>

                @endif

            </div>

        </div>

    </main>

</body>
</html>