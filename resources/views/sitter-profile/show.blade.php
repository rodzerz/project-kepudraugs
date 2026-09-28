<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mans pieskatītāja profils - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-sitter-nav />

    <main class="page-container">

        <!-- PROFILA GALVENE -->

        <section class="sitter-profile-hero">

            <div class="sitter-profile-avatar">
                {{ mb_strtoupper(mb_substr($profile->user->name, 0, 1)) }}
            </div>

            <div class="sitter-profile-heading">

                <p class="section-label">
                    Mans pieskatītāja profils
                </p>

                <h1>
                    {{ $profile->user->name }}
                </h1>

                <div class="sitter-profile-meta">

                    <span>
                        📍 {{ $profile->city }}
                    </span>

                    <span>
                        💶 {{ $profile->price }} € / dienā
                    </span>

                    @if ($reviews->count() > 0)

                        <span>
                            ⭐ {{ number_format($averageRating, 1) }}
                            ({{ $reviews->count() }})
                        </span>

                    @else

                        <span>
                            ☆ Nav atsauksmju
                        </span>

                    @endif

                </div>

                <p class="sitter-profile-helper">
                    Šo informāciju redz mājdzīvnieku īpašnieki,
                    kuri meklē pieskatītāju.
                </p>

            </div>

            <div class="sitter-profile-actions">

                <a href="/sitter-profile/create" class="main-button">
                    ✏️ Rediģēt profilu
                </a>

            </div>

        </section>


        <!-- INFORMĀCIJA -->

        <section class="profile-section">

            <div class="profile-section-heading">

                <div>
                    <p class="section-label">
                        Profila informācija
                    </p>

                    <h2>
                        Par mani
                    </h2>
                </div>

            </div>


            <div class="sitter-info-grid">

                <div class="sitter-info-card">

                    <div class="sitter-info-icon">
                        📍
                    </div>

                    <div>
                        <span class="sitter-info-label">
                            Pilsēta
                        </span>

                        <strong>
                            {{ $profile->city }}
                        </strong>
                    </div>

                </div>


                <div class="sitter-info-card">

                    <div class="sitter-info-icon">
                        💶
                    </div>

                    <div>
                        <span class="sitter-info-label">
                            Cena
                        </span>

                        <strong>
                            {{ $profile->price }} € / dienā
                        </strong>
                    </div>

                </div>


                <div class="sitter-info-card">

                    <div class="sitter-info-icon">
                        🐾
                    </div>

                    <div>
                        <span class="sitter-info-label">
                            Pieskatāmie dzīvnieki
                        </span>

                        <strong>
                            {{ $profile->accepted_animals }}
                        </strong>
                    </div>

                </div>

            </div>


            <div class="sitter-detail-grid">

                <article class="sitter-detail-card">

                    <div class="sitter-detail-title">
                        <span>👤</span>
                        <h3>Par sevi</h3>
                    </div>

                    <p>
                        {{ $profile->description ?? 'Informācija nav norādīta.' }}
                    </p>

                </article>


                <article class="sitter-detail-card">

                    <div class="sitter-detail-title">
                        <span>⭐</span>
                        <h3>Pieredze</h3>
                    </div>

                    <p>
                        {{ $profile->experience ?? 'Pieredze nav norādīta.' }}
                    </p>

                </article>

            </div>

        </section>


        <!-- VĒRTĒJUMS -->

        <section class="profile-section">

            <div class="profile-section-heading">

                <div>
                    <p class="section-label">
                        Vērtējums
                    </p>

                    <h2>
                        Klientu novērtējums
                    </h2>
                </div>

            </div>


            <div class="rating-summary">

                @if ($reviews->count() > 0)

                    <div class="rating-score">

                        <strong>
                            {{ number_format($averageRating, 1) }}
                        </strong>

                        <span>
                            no 5
                        </span>

                    </div>


                    <div class="rating-details">

                        <div class="rating-stars">

                            @for ($i = 1; $i <= 5; $i++)

                                @if ($i <= round($averageRating))
                                    <span>★</span>
                                @else
                                    <span class="empty-star">★</span>
                                @endif

                            @endfor

                        </div>

                        <p>
                            Balstīts uz
                            <strong>{{ $reviews->count() }}</strong>
                            {{ $reviews->count() == 1 ? 'atsauksmi' : 'atsauksmēm' }}
                        </p>

                    </div>

                @else

                    <div class="empty-state">

                        <div class="empty-state-icon">
                            ☆
                        </div>

                        <h3>
                            Vēl nav vērtējumu
                        </h3>

                        <p>
                            Kad mājdzīvnieku īpašnieki būs pabeiguši
                            rezervāciju un atstājuši atsauksmi,
                            vērtējums būs redzams šeit.
                        </p>

                    </div>

                @endif

            </div>

        </section>


        <!-- ATSAUKSMES -->

        <section class="profile-section">

            <div class="profile-section-heading">

                <div>
                    <p class="section-label">
                        Atsauksmes
                    </p>

                    <h2>
                        Ko saka mājdzīvnieku īpašnieki?
                    </h2>
                </div>

                @if ($reviews->count() > 0)

                    <span class="review-count">
                        {{ $reviews->count() }}
                        {{ $reviews->count() == 1 ? 'atsauksme' : 'atsauksmes' }}
                    </span>

                @endif

            </div>


            @if ($reviews->count() > 0)

                <div class="reviews-list">

                    @foreach ($reviews as $review)

                        <article class="review-card">

                            <div class="review-header">

                                <div class="review-user">

                                    <div class="review-avatar">
                                        {{ mb_strtoupper(mb_substr($review->owner->name, 0, 1)) }}
                                    </div>

                                    <div>

                                        <strong>
                                            {{ $review->owner->name }}
                                        </strong>

                                        <span class="review-date">
                                            {{ $review->created_at->format('d.m.Y.') }}
                                        </span>

                                    </div>

                                </div>


                                <div
                                    class="review-stars"
                                    aria-label="{{ $review->rating }} no 5 zvaigznēm"
                                >

                                    @for ($i = 1; $i <= 5; $i++)

                                        @if ($i <= $review->rating)
                                            <span>★</span>
                                        @else
                                            <span class="empty-star">★</span>
                                        @endif

                                    @endfor

                                </div>

                            </div>


                            @if ($review->review)

                                <p class="review-text">
                                    {{ $review->review }}
                                </p>

                            @else

                                <p class="review-text review-text-empty">
                                    Atsauksmes teksts nav pievienots.
                                </p>

                            @endif

                        </article>

                    @endforeach

                </div>

            @else

                <div class="empty-state reviews-empty">

                    <div class="empty-state-icon">
                        💬
                    </div>

                    <h3>
                        Pagaidām nav atsauksmju
                    </h3>

                    <p>
                        Šeit tiks parādītas mājdzīvnieku īpašnieku
                        atstātās atsauksmes.
                    </p>

                </div>

            @endif

        </section>

    </main>

</body>
</html>