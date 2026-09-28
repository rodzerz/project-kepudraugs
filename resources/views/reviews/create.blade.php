<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Atstāt atsauksmi - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-owner-nav />

    <main class="page-container">

        <!-- LAPAS GALVENE -->

        <section class="review-page-header">

            <div class="review-page-icon">
                ⭐
            </div>

            <div>

                <p class="section-label">
                    Rezervācijas novērtējums
                </p>

                <h1 class="page-title">
                    Atstāt atsauksmi
                </h1>

                <p class="page-description">
                    Novērtē savu pieredzi ar pieskatītāju.
                    Tava atsauksme palīdzēs arī citiem mājdzīvnieku īpašniekiem.
                </p>

            </div>

        </section>


        <!-- GALVENAIS SATURS -->

        <section class="review-layout">

            <!-- FORMA -->

            <div class="review-form-card">

                <div class="review-form-heading">

                    <p class="section-label">
                        Tavs vērtējums
                    </p>

                    <h2>
                        Kāda bija tava pieredze?
                    </h2>

                    <p>
                        Izvēlies vērtējumu un, ja vēlies,
                        pievieno arī īsu atsauksmi.
                    </p>

                </div>


                @if ($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            Lūdzu, pārbaudi ievadīto informāciju.
                        </strong>

                        @foreach ($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach

                    </div>

                @endif


                <form
                    action="/bookings/{{ $booking->id }}/review"
                    method="POST"
                >

                    @csrf


                    <!-- VĒRTĒJUMS -->

                    <div class="form-group">

                        <label for="rating">
                            Vērtējums *
                        </label>

                        <select
                            name="rating"
                            id="rating"
                            required
                        >

                            <option value="">
                                Izvēlies vērtējumu
                            </option>

                            <option
                                value="5"
                                {{ old('rating') == '5' ? 'selected' : '' }}
                            >
                                ⭐⭐⭐⭐⭐ – Lieliski
                            </option>

                            <option
                                value="4"
                                {{ old('rating') == '4' ? 'selected' : '' }}
                            >
                                ⭐⭐⭐⭐ – Ļoti labi
                            </option>

                            <option
                                value="3"
                                {{ old('rating') == '3' ? 'selected' : '' }}
                            >
                                ⭐⭐⭐ – Labi
                            </option>

                            <option
                                value="2"
                                {{ old('rating') == '2' ? 'selected' : '' }}
                            >
                                ⭐⭐ – Vidēji
                            </option>

                            <option
                                value="1"
                                {{ old('rating') == '1' ? 'selected' : '' }}
                            >
                                ⭐ – Slikti
                            </option>

                        </select>

                        @error('rating')
                            <p class="field-error">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <!-- ATSAUKSME -->

                    <div class="form-group">

                        <label for="review">
                            Atsauksme
                        </label>

                        <textarea
                            name="review"
                            id="review"
                            rows="6"
                            maxlength="2000"
                            placeholder="Uzraksti savu atsauksmi par pieskatītāju..."
                        >{{ old('review') }}</textarea>

                        <div class="form-help-row">

                            <span class="form-help">
                                Atsauksmes teksts nav obligāts.
                            </span>

                            <span class="form-help">
                                Maks. 2000 rakstzīmes
                            </span>

                        </div>

                        @error('review')
                            <p class="field-error">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <!-- POGAS -->

                    <div class="review-form-actions">

                        <button
                            type="submit"
                            class="main-button"
                        >
                            ⭐ Iesniegt atsauksmi
                        </button>

                        <a
                            href="/bookings"
                            class="secondary-button"
                        >
                            Atcelt
                        </a>

                    </div>

                </form>

            </div>


            <!-- REZERVĀCIJAS INFORMĀCIJA -->

            <aside class="review-booking-card">

                <div class="review-sitter-avatar">
                    {{ mb_strtoupper(mb_substr($booking->sitter->name, 0, 1)) }}
                </div>

                <p class="section-label">
                    Pieskatītājs
                </p>

                <h2>
                    {{ $booking->sitter->name }}
                </h2>

                <div class="review-booking-divider"></div>


                <div class="review-booking-info">

                    <div class="review-booking-row">

                        <span class="review-booking-icon">
                            📅
                        </span>

                        <div>

                            <span class="review-booking-label">
                                Rezervācijas datums
                            </span>

                            <strong>
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y.') }}
                            </strong>

                        </div>

                    </div>


                    <div class="review-booking-row">

                        <span class="review-booking-icon">
                            🐾
                        </span>

                        <div>

                            <span class="review-booking-label">
                                Dzīvnieks
                            </span>

                            <strong>
                                {{ $booking->pet_type }}
                            </strong>

                        </div>

                    </div>


                    <div class="review-booking-row">

                        <span class="review-booking-icon">
                            ✓
                        </span>

                        <div>

                            <span class="review-booking-label">
                                Rezervācijas statuss
                            </span>

                            <strong class="review-completed">
                                Pabeigta
                            </strong>

                        </div>

                    </div>

                </div>


                <div class="review-note">

                    <span>
                        💡
                    </span>

                    <p>
                        Raksti godīgu un noderīgu atsauksmi par savu
                        pieredzi ar pieskatītāju.
                    </p>

                </div>

            </aside>

        </section>

    </main>

</body>
</html>