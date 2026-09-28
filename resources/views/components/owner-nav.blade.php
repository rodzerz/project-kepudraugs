<header class="header">

    <div class="header-content">

        <!-- LOGO -->

        <a href="/dashboard" class="logo">

            <span class="logo-icon">
                🐾
            </span>

            <span>
                ĶepuDraugs.lv
            </span>

        </a>


        <!-- NAVIGĀCIJA -->

        <nav class="main-nav">

            <a
                href="/dashboard"
                class="{{ request()->is('dashboard') ? 'active' : '' }}"
            >
                Sākums
            </a>

            <a
                href="/sitters"
                class="{{ request()->is('sitters*') ? 'active' : '' }}"
            >
                Pieskatītāji
            </a>

            <a
                href="/pets"
                class="{{ request()->is('pets*') ? 'active' : '' }}"
            >
                Mani mājdzīvnieki
            </a>

            <a
                href="/bookings"
                class="{{ request()->is('bookings') || request()->is('bookings/create/*') || request()->is('bookings/*/messages') || request()->is('bookings/*/review') ? 'active' : '' }}"
            >
                Manas rezervācijas
            </a>

            <a
                href="/profile"
                class="{{ request()->is('profile*') ? 'active' : '' }}"
            >
                Mans profils
            </a>


            <!-- IZLOGOŠANĀS -->

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