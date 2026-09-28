<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administrators - ĶepuDraugs.lv</title>

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

                <a
                    href="/admin"
                    class="active"
                >
                    Lietotāji
                </a>

                <a href="/admin/bookings">
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

        <!-- GALVENE -->

        <section class="admin-page-header">

            <div>

                <p class="section-label">
                    Administratora panelis
                </p>

                <h1 class="page-title">
                    Sistēmas pārvaldība
                </h1>

                <p class="page-description">
                    Sveiks, {{ Auth::user()->name }}!
                    Šeit vari pārraudzīt sistēmas statistiku,
                    lietotājus un rezervāciju aktivitāti.
                </p>

            </div>


            <div class="admin-page-header-icon">
                ⚙️
            </div>

        </section>


        <!-- PAZIŅOJUMI -->

        @if (session('success'))

            <div class="alert alert-success">

                <strong>
                    {{ session('success') }}
                </strong>

            </div>

        @endif


        @if (session('error'))

            <div class="alert alert-danger">

                <strong>
                    {{ session('error') }}
                </strong>

            </div>

        @endif


        <!-- STATISTIKA -->

        <section class="admin-section">

            <div class="admin-section-heading">

                <div>

                    <p class="section-label">
                        Pārskats
                    </p>

                    <h2>
                        Sistēmas statistika
                    </h2>

                </div>

            </div>


            <div class="admin-stats-grid">

                <!-- LIETOTĀJI -->

                <article class="admin-stat-card">

                    <div class="admin-stat-icon">
                        👥
                    </div>

                    <div>

                        <strong class="admin-stat-number">
                            {{ $totalUsers }}
                        </strong>

                        <span class="admin-stat-title">
                            Lietotāji
                        </span>

                    </div>

                </article>


                <!-- ĪPAŠNIEKI -->

                <article class="admin-stat-card">

                    <div class="admin-stat-icon">
                        🏠
                    </div>

                    <div>

                        <strong class="admin-stat-number">
                            {{ $totalOwners }}
                        </strong>

                        <span class="admin-stat-title">
                            Īpašnieki
                        </span>

                    </div>

                </article>


                <!-- PIESKATĪTĀJI -->

                <article class="admin-stat-card">

                    <div class="admin-stat-icon">
                        🐾
                    </div>

                    <div>

                        <strong class="admin-stat-number">
                            {{ $totalSitters }}
                        </strong>

                        <span class="admin-stat-title">
                            Pieskatītāji
                        </span>

                    </div>

                </article>


                <!-- BLOĶĒTIE -->

                <article class="admin-stat-card">

                    <div class="admin-stat-icon admin-stat-icon-danger">
                        🚫
                    </div>

                    <div>

                        <strong class="admin-stat-number">
                            {{ $blockedUsers }}
                        </strong>

                        <span class="admin-stat-title">
                            Bloķēti lietotāji
                        </span>

                    </div>

                </article>


                <!-- REZERVĀCIJAS -->

                <article class="admin-stat-card">

                    <div class="admin-stat-icon">
                        📅
                    </div>

                    <div>

                        <strong class="admin-stat-number">
                            {{ $totalBookings }}
                        </strong>

                        <span class="admin-stat-title">
                            Rezervācijas
                        </span>

                    </div>

                </article>


                <!-- PABEIGTĀS -->

                <article class="admin-stat-card">

                    <div class="admin-stat-icon admin-stat-icon-success">
                        ✓
                    </div>

                    <div>

                        <strong class="admin-stat-number">
                            {{ $completedBookings }}
                        </strong>

                        <span class="admin-stat-title">
                            Pabeigtas rezervācijas
                        </span>

                    </div>

                </article>

            </div>

        </section>


        <!-- REZERVĀCIJU STATUSI -->

        <section class="admin-section admin-booking-status-section">

            <div class="admin-section-heading">

                <div>

                    <p class="section-label">
                        Rezervācijas
                    </p>

                    <h2>
                        Rezervāciju statusi
                    </h2>

                    <p>
                        Rezervāciju sadalījums pēc to
                        pašreizējā statusa.
                    </p>

                </div>


                <a
                    href="/admin/bookings"
                    class="secondary-button"
                >
                    Skatīt visas rezervācijas
                </a>

            </div>


            <div class="admin-status-grid">

                <div class="admin-status-card">

                    <span class="status status-pending">
                        Gaida
                    </span>

                    <strong>
                        {{ $pendingBookings }}
                    </strong>

                    <span>
                        rezervācijas
                    </span>

                </div>


                <div class="admin-status-card">

                    <span class="status status-accepted">
                        Pieņemtas
                    </span>

                    <strong>
                        {{ $acceptedBookings }}
                    </strong>

                    <span>
                        rezervācijas
                    </span>

                </div>


                <div class="admin-status-card">

                    <span class="status status-completed">
                        Pabeigtas
                    </span>

                    <strong>
                        {{ $completedBookings }}
                    </strong>

                    <span>
                        rezervācijas
                    </span>

                </div>


                <div class="admin-status-card">

                    <span class="status status-rejected">
                        Noraidītas
                    </span>

                    <strong>
                        {{ $rejectedBookings }}
                    </strong>

                    <span>
                        rezervācijas
                    </span>

                </div>


                <div class="admin-status-card">

                    <span class="status status-cancelled">
                        Atceltas
                    </span>

                    <strong>
                        {{ $cancelledBookings }}
                    </strong>

                    <span>
                        rezervācijas
                    </span>

                </div>

            </div>

        </section>


        <!-- LIETOTĀJI -->

        <section class="admin-section">

            <div class="admin-section-heading">

                <div>

                    <p class="section-label">
                        Kontu pārvaldība
                    </p>

                    <h2>
                        Reģistrētie lietotāji
                    </h2>

                    <p>
                        Apskati sistēmā reģistrētos lietotājus
                        un nepieciešamības gadījumā bloķē vai
                        atbloķē viņu kontus.
                    </p>

                </div>


                <span class="admin-results-count">
                    {{ $users->count() }}
                    {{ $users->count() == 1 ? 'lietotājs' : 'lietotāji' }}
                </span>

            </div>


            @if ($users->count() > 0)

                <div class="admin-table-wrapper">

                    <table class="admin-table">

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Lietotājs</th>
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

                                    <!-- ID -->

                                    <td>
                                        <span class="admin-user-id">
                                            #{{ $user->id }}
                                        </span>
                                    </td>


                                    <!-- LIETOTĀJS -->

                                    <td>

                                        <div class="admin-user-cell">

                                            <div class="admin-user-avatar">
                                                {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                                            </div>

                                            <strong>
                                                {{ $user->name }}
                                            </strong>

                                        </div>

                                    </td>


                                    <!-- E-PASTS -->

                                    <td>
                                        {{ $user->email }}
                                    </td>


                                    <!-- LOMA -->

                                    <td>

                                        @if ($user->role === 'admin')

                                            <span class="admin-role-badge admin-role-admin">
                                                Administrators
                                            </span>

                                        @elseif ($user->role === 'owner')

                                            <span class="admin-role-badge">
                                                Īpašnieks
                                            </span>

                                        @elseif ($user->role === 'sitter')

                                            <span class="admin-role-badge">
                                                Pieskatītājs
                                            </span>

                                        @else

                                            <span class="admin-role-badge">
                                                {{ $user->role }}
                                            </span>

                                        @endif

                                    </td>


                                    <!-- REĢISTRĀCIJAS DATUMS -->

                                    <td>
                                        {{ $user->created_at->format('d.m.Y.') }}
                                    </td>


                                    <!-- STATUSS -->

                                    <td>

                                        @if ($user->is_blocked)

                                            <span class="status status-rejected">
                                                Bloķēts
                                            </span>

                                        @else

                                            <span class="status status-accepted">
                                                Aktīvs
                                            </span>

                                        @endif

                                    </td>


                                    <!-- DARBĪBA -->

                                    <td>

                                        @if ($user->id !== Auth::id())

                                            <form
                                                action="/admin/users/{{ $user->id }}/toggle-block"
                                                method="POST"
                                                class="admin-user-action-form"
                                            >

                                                @csrf


                                                @if ($user->is_blocked)

                                                    <button
                                                        type="submit"
                                                        class="admin-unblock-button"
                                                    >
                                                        🔓 Atbloķēt
                                                    </button>

                                                @else

                                                    <button
                                                        type="submit"
                                                        class="admin-block-button"
                                                        onclick="return confirm('Vai tiešām vēlaties bloķēt šo lietotāju?');"
                                                    >
                                                        🚫 Bloķēt
                                                    </button>

                                                @endif

                                            </form>

                                        @else

                                            <span class="admin-current-user">
                                                👑 Tavs konts
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


            @else

                <div class="admin-empty-state">

                    <div class="empty-state-icon">
                        👥
                    </div>

                    <h3>
                        Nav reģistrētu lietotāju
                    </h3>

                    <p>
                        Sistēmā pašlaik nav lietotāju, ko attēlot.
                    </p>

                </div>

            @endif

        </section>

    </main>

</body>
</html>