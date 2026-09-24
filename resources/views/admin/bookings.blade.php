<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rezervāciju pārvaldība - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <main class="page-container">

        <div>
            <p class="subtitle">🐾 Administrēšana</p>

            <h1 class="page-title">
                Rezervāciju pārvaldība
            </h1>

            <p class="page-description">
                Šeit administrators var apskatīt visas sistēmā izveidotās
                rezervācijas un to pašreizējo statusu.
            </p>
        </div>

        <div style="margin-bottom: 25px;">
            <a href="/admin" class="main-button">
                ← Lietotāju pārvaldība
            </a>
        </div>

        @if (session('success'))

            <div class="alert alert-success">
                <strong>{{ session('success') }}</strong>
            </div>

        @endif

        @if ($bookings->count() > 0)

            <div class="card" style="overflow-x: auto;">

                <table style="width: 100%;">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Īpašnieks</th>
                            <th>Pieskatītājs</th>
                            <th>Mājdzīvnieks</th>
                            <th>Datums</th>
                            <th>Laiks</th>
                            <th>Statuss</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($bookings as $booking)

                            <tr>

                                <td>
                                    {{ $booking->id }}
                                </td>

                                <td>
                                    {{ $booking->owner->name }}
                                </td>

                                <td>
                                    {{ $booking->sitter->name }}
                                </td>

                                <td>
                                    {{ $booking->pet_type }}
                                </td>

                                <td>
                                    {{ $booking->booking_date }}
                                </td>

                                <td>
                                    {{ $booking->start_time }}
                                    -
                                    {{ $booking->end_time }}
                                </td>

                                <td>

                                    @if ($booking->status === 'pending')

                                        <span class="status status-pending">
                                            Gaida apstiprinājumu
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

                                    @else

                                        <span>
                                            {{ $booking->status }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="card" style="text-align: center;">

                <h3>📅 Nav rezervāciju</h3>

                <p class="page-description">
                    Sistēmā pašlaik nav izveidota neviena rezervācija.
                </p>

            </div>

        @endif

    </main>

</body>
</html>