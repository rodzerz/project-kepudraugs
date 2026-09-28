<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rezervāciju pārvaldība - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- ADMINISTRATORA NAVIGĀCIJA -->

    <header class="header admin-header">

        <div class="header-content">

            <a href="/admin" class="logo">

                <span class="logo-icon">
                    🐾
                </span>

                <span>
                    ĶepuDraugs.lv
                </span>

                <span class="admin-logo-badge">
                    Admin
                </span>

            </a>


            <nav class="main-nav">

                <a href="/admin">
                    Lietotāji
                </a>

                <a
                    href="/admin/bookings"
                    class="active"
                >
                    Rezervācijas
                </a>

                <a href="/admin/pets">
                    Mājdzīvnieki
                </a>


                <form
                    action="/logout"
                    method="POST"
                    class="logout-form"
                >

                    @csrf

                    <button
                        type="submit"
                        class="logout-button"
                    >
                        Iziet
                    </button>

                </form>

            </nav>

        </div>

    </header>


    <main class="page-container">

        <!-- LAPAS GALVENE -->

        <section class="admin-page-header">

            <div>

                <p class="section-label">
                    Administratora panelis
                </p>

                <h1 class="page-title">
                    Rezervāciju pārvaldība
                </h1>

                <p class="page-description">
                    Apskati visas sistēmā izveidotās rezervācijas,
                    to dalībniekus, laiku un pašreizējo statusu.
                </p>

            </div>


            <div class="admin-page-header-icon">
                📅
            </div>

        </section>


        <!-- PAZIŅOJUMS -->

        @if (session('success'))

            <div class="alert alert-success">

                <strong>
                    {{ session('success') }}
                </strong>

            </div>

        @endif


        <!-- REZERVĀCIJAS -->

        <section class="admin-section">

            <div class="admin-section-heading">

                <div>

                    <p class="section-label">
                        Sistēmas rezervācijas
                    </p>

                    <h2>
                        Visas rezervācijas
                    </h2>

                    <p>
                        Pilns sistēmā izveidoto rezervāciju pārskats.
                    </p>

                </div>


                <span class="admin-results-count">
                    {{ $bookings->count() }}
                    {{ $bookings->count() == 1 ? 'rezervācija' : 'rezervācijas' }}
                </span>

            </div>


            @if ($bookings->count() > 0)

                <!-- TABULA -->

                <div class="admin-table-wrapper">

                    <table class="admin-table admin-bookings-table">

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

                                    <!-- ID -->

                                    <td>

                                        <span class="admin-booking-id">
                                            #{{ $booking->id }}
                                        </span>

                                    </td>


                                    <!-- ĪPAŠNIEKS -->

                                    <td>

                                        <div class="admin-booking-person">

                                            <div class="admin-booking-avatar">
                                                {{ mb_strtoupper(mb_substr($booking->owner->name, 0, 1)) }}
                                            </div>

                                            <div>

                                                <span class="admin-booking-person-label">
                                                    Īpašnieks
                                                </span>

                                                <strong>
                                                    {{ $booking->owner->name }}
                                                </strong>

                                            </div>

                                        </div>

                                    </td>


                                    <!-- PIESKATĪTĀJS -->

                                    <td>

                                        <div class="admin-booking-person">

                                            <div class="admin-booking-avatar">
                                                {{ mb_strtoupper(mb_substr($booking->sitter->name, 0, 1)) }}
                                            </div>

                                            <div>

                                                <span class="admin-booking-person-label">
                                                    Pieskatītājs
                                                </span>

                                                <strong>
                                                    {{ $booking->sitter->name }}
                                                </strong>

                                            </div>

                                        </div>

                                    </td>


                                    <!-- MĀJDZĪVNIEKS -->

                                    <td>

                                        <div class="admin-booking-pet">

                                            <span>
                                                🐾
                                            </span>

                                            <strong>
                                                {{ $booking->pet_type }}
                                            </strong>

                                        </div>

                                    </td>


                                    <!-- DATUMS -->

                                    <td>

                                        <div class="admin-booking-date">

                                            <span>
                                                📅
                                            </span>

                                            <strong>
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y.') }}
                                            </strong>

                                        </div>

                                    </td>


                                    <!-- LAIKS -->

                                    <td>

                                        <div class="admin-booking-time">

                                            <span>
                                                🕐
                                            </span>

                                            <strong>
                                                {{ substr($booking->start_time, 0, 5) }}
                                                –
                                                {{ substr($booking->end_time, 0, 5) }}
                                            </strong>

                                        </div>

                                    </td>


                                    <!-- STATUSS -->

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

                                        @else

                                            <span class="status">
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

                <!-- TUKŠS STĀVOKLIS -->

                <div class="admin-empty-state">

                    <div class="empty-state-icon">
                        📅
                    </div>

                    <h3>
                        Nav rezervāciju
                    </h3>

                    <p>
                        Sistēmā pašlaik nav izveidota neviena rezervācija.
                    </p>

                </div>

            @endif

        </section>

    </main>

</body>
</html>