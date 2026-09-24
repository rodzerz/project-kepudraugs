<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administrators - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        .admin-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin: 25px 0 30px;
        }

        .admin-stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            box-shadow: var(--shadow);
        }

        .admin-stat-icon {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .admin-stat-number {
            font-size: 30px;
            font-weight: 700;
            color: var(--primary);
            margin: 5px 0;
        }

        .admin-stat-title {
            color: var(--text-light);
            margin: 0;
        }

        .booking-stats {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <main class="page-container">

        <div>
            <p class="subtitle">
                🐾 Administrēšana
            </p>

            <h1 class="page-title">
                ĶepuDraugs.lv administrēšana
            </h1>

            <p class="page-description">
                Sveiki, {{ Auth::user()->name }}!
            </p>
        </div>

        {{-- Administratora navigācija --}}
        <div style="
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        ">

            <a href="/admin" class="main-button">
                👥 Lietotāji
            </a>

            <a href="/admin/bookings" class="main-button">
                📅 Rezervācijas
            </a>

            <a href="/admin/pets" class="main-button">
                🐕 Mājdzīvnieki
            </a>

            <form
                action="/logout"
                method="POST"
                style="margin: 0;"
            >
                @csrf

                <button type="submit">
                    Iziet
                </button>
            </form>

        </div>

        {{-- Veiksmīgs paziņojums --}}
        @if (session('success'))

            <div class="alert alert-success">
                <strong>
                    {{ session('success') }}
                </strong>
            </div>

        @endif

        {{-- Kļūdas paziņojums --}}
        @if (session('error'))

            <div class="alert">
                <strong>
                    {{ session('error') }}
                </strong>
            </div>

        @endif


        {{-- STATISTIKA --}}
        <h2>
            📊 Sistēmas statistika
        </h2>

        <div class="admin-stats">

            <div class="admin-stat-card">
                <div class="admin-stat-icon">
                    👥
                </div>

                <div class="admin-stat-number">
                    {{ $totalUsers }}
                </div>

                <p class="admin-stat-title">
                    Lietotāji
                </p>
            </div>


            <div class="admin-stat-card">
                <div class="admin-stat-icon">
                    🏠
                </div>

                <div class="admin-stat-number">
                    {{ $totalOwners }}
                </div>

                <p class="admin-stat-title">
                    Īpašnieki
                </p>
            </div>


            <div class="admin-stat-card">
                <div class="admin-stat-icon">
                    🐾
                </div>

                <div class="admin-stat-number">
                    {{ $totalSitters }}
                </div>

                <p class="admin-stat-title">
                    Pieskatītāji
                </p>
            </div>


            <div class="admin-stat-card">
                <div class="admin-stat-icon">
                    🚫
                </div>

                <div class="admin-stat-number">
                    {{ $blockedUsers }}
                </div>

                <p class="admin-stat-title">
                    Bloķēti lietotāji
                </p>
            </div>


            <div class="admin-stat-card">
                <div class="admin-stat-icon">
                    📅
                </div>

                <div class="admin-stat-number">
                    {{ $totalBookings }}
                </div>

                <p class="admin-stat-title">
                    Rezervācijas
                </p>
            </div>


            <div class="admin-stat-card">
                <div class="admin-stat-icon">
                    ✅
                </div>

                <div class="admin-stat-number">
                    {{ $completedBookings }}
                </div>

                <p class="admin-stat-title">
                    Pabeigtas rezervācijas
                </p>
            </div>

        </div>


        {{-- REZERVĀCIJU STATUSU STATISTIKA --}}
        <div class="card">

            <h2>
                📅 Rezervāciju statusi
            </h2>

            <p class="page-description">
                Rezervāciju sadalījums pēc to pašreizējā statusa.
            </p>

            <div class="booking-stats">

                <span class="status status-pending">
                    Gaida: {{ $pendingBookings }}
                </span>

                <span class="status status-accepted">
                    Pieņemtas: {{ $acceptedBookings }}
                </span>

                <span class="status status-accepted">
                    Pabeigtas: {{ $completedBookings }}
                </span>

                <span class="status status-rejected">
                    Noraidītas: {{ $rejectedBookings }}
                </span>

                <span class="status status-cancelled">
                    Atceltas: {{ $cancelledBookings }}
                </span>

            </div>

        </div>


        {{-- LIETOTĀJU TABULA --}}
        <div class="card">

            <h2>
                👥 Reģistrētie lietotāji
            </h2>

            <p class="page-description">
                Šeit vari apskatīt sistēmā reģistrētos lietotājus
                un bloķēt vai atbloķēt viņu kontus.
            </p>

            @if ($users->count() > 0)

                <div style="overflow-x: auto;">

                    <table style="width: 100%;">

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Vārds</th>
                                <th>E-pasts</th>
                                <th>Loma</th>
                                <th>Reģistrēts</th>
                                <th>Statuss</th>
                                <th>Darbība</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($users as $user)

                                <tr>

                                    <td>
                                        {{ $user->id }}
                                    </td>

                                    <td>
                                        {{ $user->name }}
                                    </td>

                                    <td>
                                        {{ $user->email }}
                                    </td>

                                    <td>

                                        @if ($user->role === 'admin')

                                            Administrators

                                        @elseif ($user->role === 'owner')

                                            Īpašnieks

                                        @elseif ($user->role === 'sitter')

                                            Pieskatītājs

                                        @else

                                            {{ $user->role }}

                                        @endif

                                    </td>

                                    <td>
                                        {{ $user->created_at->format('d.m.Y') }}
                                    </td>

                                    <td>

                                        @if ($user->is_blocked)

                                            <span class="status status-rejected">
                                                🚫 Bloķēts
                                            </span>

                                        @else

                                            <span class="status status-accepted">
                                                ✅ Aktīvs
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        @if ($user->id !== Auth::id())

                                            <form
                                                action="/admin/users/{{ $user->id }}/toggle-block"
                                                method="POST"
                                                style="margin: 0;"
                                            >

                                                @csrf

                                                @if ($user->is_blocked)

                                                    <button type="submit">
                                                        🔓 Atbloķēt
                                                    </button>

                                                @else

                                                    <button
                                                        type="submit"
                                                        style="background: var(--danger);"
                                                    >
                                                        🚫 Bloķēt
                                                    </button>

                                                @endif

                                            </form>

                                        @else

                                            <span class="status status-accepted">
                                                👑 Administrators
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <p>
                    Nav reģistrētu lietotāju.
                </p>

            @endif

        </div>

    </main>

</body>

</html>