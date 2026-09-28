<header class="header">

    <div class="header-content">

        <a href="/dashboard" class="logo">
            <span class="logo-icon">🐾</span>
            <span>ĶepuDraugs.lv</span>
        </a>

        <nav class="main-nav">

            <a href="/dashboard"
                class="{{ request()->is('dashboard') ? 'active' : '' }}">
                Sākums
            </a>

            <a href="/sitter-profile"
                class="{{ request()->is('sitter-profile*') ? 'active' : '' }}">
                Pieskatītāja profils
            </a>

            <a href="/bookings/sitter"
                class="{{ request()->is('bookings/sitter') ? 'active' : '' }}">
                Rezervācijas
            </a>

            <a href="/profile"
                class="{{ request()->is('profile*') ? 'active' : '' }}">
                Mans profils
            </a>

            <form action="/logout" method="POST" class="logout-form">
                @csrf

                <button type="submit" class="logout-button">
                    Iziet
                </button>
            </form>

        </nav>

    </div>

</header>