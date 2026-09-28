<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Veikt rezervāciju - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-owner-nav />

    <main class="page-container">

        <!-- LAPAS GALVENE -->

        <section class="booking-form-header">

            <div class="booking-form-header-icon">
                📅
            </div>

            <div>

                <p class="section-label">
                    Jauna rezervācija
                </p>

                <h1 class="page-title">
                    Veikt rezervāciju
                </h1>

                <p class="page-description">
                    Izvēlies piemērotu datumu un laiku un nosūti
                    rezervācijas pieprasījumu pieskatītājam.
                </p>

            </div>

        </section>


        <!-- SATURS -->

        <section class="booking-form-layout">

            <!-- FORMA -->

            <div class="booking-form-card">

                <div class="booking-form-card-heading">

                    <div>

                        <p class="section-label">
                            Rezervācijas informācija
                        </p>

                        <h2>
                            Izvēlies rezervācijas laiku
                        </h2>

                    </div>

                    <span class="required-note">
                        * Obligātie lauki
                    </span>

                </div>


                <!-- KĻŪDAS -->

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            Lūdzu, pārbaudi ievadīto informāciju.
                        </strong>

                        <div class="form-error-list">

                            @foreach ($errors->all() as $error)

                                <p>
                                    • {{ $error }}
                                </p>

                            @endforeach

                        </div>

                    </div>

                @endif


                <form action="/bookings" method="POST">

                    @csrf

                    <input
                        type="hidden"
                        name="sitter_id"
                        value="{{ $sitterProfile->user_id }}"
                    >


                    <!-- MĀJDZĪVNIEKA VEIDS -->

                    <div class="form-group">

                        <label for="pet_type">
                            Mājdzīvnieka veids *
                        </label>

                        <input
                            type="text"
                            id="pet_type"
                            name="pet_type"
                            value="{{ old('pet_type') }}"
                            placeholder="Piemēram, Suns"
                            required
                        >

                        <span class="form-help">
                            Norādi, kādu mājdzīvnieku nepieciešams pieskatīt.
                        </span>

                        @error('pet_type')

                            <p class="field-error">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <!-- DATUMS -->

                    <div class="form-group">

                        <label for="booking_date">
                            Rezervācijas datums *
                        </label>

                        <input
                            type="date"
                            id="booking_date"
                            name="booking_date"
                            value="{{ old('booking_date') }}"
                            min="{{ date('Y-m-d') }}"
                            required
                        >

                        <span class="form-help">
                            Rezervāciju iespējams veikt šodienai vai nākotnes datumam.
                        </span>

                        @error('booking_date')

                            <p class="field-error">
                                ⚠️ {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <!-- LAIKS -->

                    <div class="booking-time-row">

                        <div class="form-group">

                            <label for="start_time">
                                Sākuma laiks *
                            </label>

                            <input
                                type="time"
                                id="start_time"
                                name="start_time"
                                value="{{ old('start_time') }}"
                                required
                            >

                            @error('start_time')

                                <p class="field-error">
                                    ⚠️ {{ $message }}
                                </p>

                            @enderror

                        </div>


                        <div class="form-group">

                            <label for="end_time">
                                Beigu laiks *
                            </label>

                            <input
                                type="time"
                                id="end_time"
                                name="end_time"
                                value="{{ old('end_time') }}"
                                required
                            >

                            @error('end_time')

                                <p class="field-error">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>


                    <!-- ZIŅA -->

                    <div class="form-group">

                        <label for="message">
                            Ziņa pieskatītājam
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            placeholder="Piemēram, informācija par mājdzīvnieka uzvedību, barošanu vai citām vajadzībām..."
                        >{{ old('message') }}</textarea>

                        <span class="form-help">
                            Vari pievienot informāciju, kas pieskatītājam
                            būtu jāzina pirms rezervācijas apstiprināšanas.
                        </span>

                        @error('message')

                            <p class="field-error">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <!-- DARBĪBAS -->

                    <div class="booking-form-actions">

                        <button
                            type="submit"
                            class="main-button"
                        >
                            📅 Nosūtīt rezervācijas pieprasījumu
                        </button>

                        <a
                            href="/sitters"
                            class="secondary-button"
                        >
                            Atcelt
                        </a>

                    </div>

                </form>

            </div>


            <!-- PIESKATĪTĀJA INFORMĀCIJA -->

            <aside class="booking-sitter-card">

                <div class="booking-sitter-avatar">
                    {{ mb_strtoupper(mb_substr($sitterProfile->user->name, 0, 1)) }}
                </div>


                <div class="booking-sitter-heading">

                    <span>
                        Tavs izvēlētais pieskatītājs
                    </span>

                    <h2>
                        {{ $sitterProfile->user->name }}
                    </h2>

                </div>


                <div class="booking-sitter-divider"></div>


                <div class="booking-sitter-details">

                    <div class="booking-sitter-detail">

                        <div class="booking-sitter-detail-icon">
                            📍
                        </div>

                        <div>

                            <span>
                                Pilsēta
                            </span>

                            <strong>
                                {{ $sitterProfile->city }}
                            </strong>

                        </div>

                    </div>


                    <div class="booking-sitter-detail">

                        <div class="booking-sitter-detail-icon">
                            💶
                        </div>

                        <div>

                            <span>
                                Cena
                            </span>

                            <strong>
                                {{ number_format($sitterProfile->price, 2, ',', ' ') }} € / dienā
                            </strong>

                        </div>

                    </div>

                </div>


                <div class="booking-sitter-note">

                    <span>
                        💡
                    </span>

                    <p>
                        Pēc pieprasījuma nosūtīšanas pieskatītājs
                        varēs to pieņemt vai noraidīt.
                    </p>

                </div>

            </aside>

        </section>

    </main>

</body>
</html>