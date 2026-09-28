<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pieskatītāji - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-owner-nav />

    <main class="page-container">

        <!-- LAPAS GALVENE -->

        <section class="sitters-page-header">

            <p class="section-label">
                Atrodi savu palīgu
            </p>

            <h1 class="page-title">
                Mājdzīvnieku pieskatītāji
            </h1>

            <p class="page-description">
                Atrodi piemērotu pieskatītāju pēc pilsētas,
                cenas un citu lietotāju vērtējuma.
            </p>

        </section>


        <!-- FILTRI -->

        <section class="sitter-filter-card">

            <div class="filter-heading">

                <div>

                    <h2>
                        Meklēšanas filtri
                    </h2>

                    <p>
                        Izmanto filtrus, lai ātrāk atrastu piemērotāko pieskatītāju.
                    </p>

                </div>

                <div class="filter-icon">
                    🔎
                </div>

            </div>


            <form method="GET" action="/sitters">

                <div class="sitter-filter-grid">

                    <!-- PILSĒTA -->

                    <div class="form-group">

                        <label for="city">
                            Pilsēta
                        </label>

                        <input
                            type="text"
                            id="city"
                            name="city"
                            value="{{ request('city') }}"
                            placeholder="Piemēram, Rīga"
                        >

                    </div>


                    <!-- CENA -->

                    <div class="form-group">

                        <label for="price_sort">
                            Kārtot pēc cenas
                        </label>

                        <select
                            id="price_sort"
                            name="price_sort"
                        >

                            <option value="">
                                Cena nav svarīga
                            </option>

                            <option
                                value="low_to_high"
                                {{ request('price_sort') == 'low_to_high' ? 'selected' : '' }}
                            >
                                Zemākā cena vispirms
                            </option>

                            <option
                                value="high_to_low"
                                {{ request('price_sort') == 'high_to_low' ? 'selected' : '' }}
                            >
                                Augstākā cena vispirms
                            </option>

                        </select>

                    </div>


                    <!-- VĒRTĒJUMS -->

                    <div class="form-group">

                        <label for="min_rating">
                            Minimālais vērtējums
                        </label>

                        <select
                            id="min_rating"
                            name="min_rating"
                        >

                            <option value="">
                                Visi vērtējumi
                            </option>

                            <option
                                value="1"
                                {{ request('min_rating') == '1' ? 'selected' : '' }}
                            >
                                ⭐ 1 un vairāk
                            </option>

                            <option
                                value="2"
                                {{ request('min_rating') == '2' ? 'selected' : '' }}
                            >
                                ⭐⭐ 2 un vairāk
                            </option>

                            <option
                                value="3"
                                {{ request('min_rating') == '3' ? 'selected' : '' }}
                            >
                                ⭐⭐⭐ 3 un vairāk
                            </option>

                            <option
                                value="4"
                                {{ request('min_rating') == '4' ? 'selected' : '' }}
                            >
                                ⭐⭐⭐⭐ 4 un vairāk
                            </option>

                            <option
                                value="5"
                                {{ request('min_rating') == '5' ? 'selected' : '' }}
                            >
                                ⭐⭐⭐⭐⭐ 5
                            </option>

                        </select>

                    </div>

                </div>


                <div class="filter-actions">

                    <button
                        type="submit"
                        class="main-button"
                    >
                        🔎 Meklēt pieskatītāju
                    </button>

                    <a
                        href="/sitters"
                        class="secondary-button"
                    >
                        Notīrīt filtrus
                    </a>

                </div>

            </form>

        </section>


        <!-- REZULTĀTI -->

        <section class="sitters-results">

            <div class="results-heading">

                <div>

                    <p class="section-label">
                        Rezultāti
                    </p>

                    <h2>
                        Pieejamie pieskatītāji
                    </h2>

                </div>

                <span class="results-count">
                    {{ $profiles->count() }}
                    {{ $profiles->count() == 1 ? 'pieskatītājs' : 'pieskatītāji' }}
                </span>

            </div>


            @if ($profiles->count() > 0)

                <div class="sitters-grid">

                    @foreach ($profiles as $profile)

                        <article class="sitter-card">

                            <!-- GALVENE -->

                            <div class="sitter-card-header">

                                <div class="sitter-avatar">
                                    {{ mb_strtoupper(mb_substr($profile->user->name, 0, 1)) }}
                                </div>

                                <div class="sitter-card-person">

                                    <h3>
                                        {{ $profile->user->name }}
                                    </h3>

                                    <span>
                                        📍 {{ $profile->city }}
                                    </span>

                                </div>

                            </div>


                            <!-- VĒRTĒJUMS -->

                            <div class="sitter-card-rating">

                                @if ($profile->reviews_count > 0)

                                    <div class="sitter-stars">

                                        @for ($i = 1; $i <= 5; $i++)

                                            @if ($i <= round($profile->average_rating))
                                                <span>★</span>
                                            @else
                                                <span class="empty-star">★</span>
                                            @endif

                                        @endfor

                                    </div>

                                    <div class="sitter-rating-text">

                                        <strong>
                                            {{ number_format($profile->average_rating, 1) }}
                                        </strong>

                                        <span>
                                            ({{ $profile->reviews_count }}
                                            {{ $profile->reviews_count == 1
                                                ? 'atsauksme'
                                                : 'atsauksmes'
                                            }})
                                        </span>

                                    </div>

                                @else

                                    <span class="no-rating">
                                        ☆ Vēl nav vērtējumu
                                    </span>

                                @endif

                            </div>


                            <!-- APRAKSTS -->

                            <div class="sitter-card-description">

                                <p>
                                    {{ $profile->description ?? 'Pieskatītājs vēl nav pievienojis aprakstu.' }}
                                </p>

                            </div>


                            <!-- INFORMĀCIJA -->

                            <div class="sitter-card-info">

                                <div class="sitter-card-info-row">

                                    <span>
                                        ⭐ Pieredze
                                    </span>

                                    <strong>
                                        {{ $profile->experience ?? 'Nav norādīta' }}
                                    </strong>

                                </div>


                                <div class="sitter-card-info-row">

                                    <span>
                                        🐾 Pieskata
                                    </span>

                                    <strong>
                                        {{ $profile->accepted_animals }}
                                    </strong>

                                </div>

                            </div>


                            <!-- APAKŠA -->

                            <div class="sitter-card-footer">

                                <div class="sitter-price">

                                    <strong>
                                        {{ number_format($profile->price, 2) }} €
                                    </strong>

                                    <span>
                                        / dienā
                                    </span>

                                </div>


                                <a
                                    href="/bookings/create/{{ $profile->id }}"
                                    class="main-button"
                                >
                                    Veikt rezervāciju
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>


            @else

                <div class="sitters-empty-state">

                    <div class="empty-state-icon">
                        🔎
                    </div>

                    <h3>
                        Pieskatītāji nav atrasti
                    </h3>

                    <p>
                        Šobrīd pēc norādītajiem kritērijiem
                        nav pieejamu pieskatītāju.
                    </p>

                    <a
                        href="/sitters"
                        class="secondary-button"
                    >
                        Notīrīt filtrus
                    </a>

                </div>

            @endif

        </section>

    </main>

</body>
</html>