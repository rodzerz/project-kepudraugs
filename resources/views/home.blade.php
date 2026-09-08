<!DOCTYPE html>

<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>ĶepuDraugs.lv</title>

<link rel="stylesheet" href="{{ asset('css/style.css') }}">


</head>

<body>


<header>
    <h1>🐾 ĶepuDraugs.lv</h1>

    @auth
        <p>Sveiks, {{ auth()->user()->name }}!</p>

        <form method="POST" action="/logout">
            @csrf
            <button type="submit">Iziet</button>
        </form>
    @else
        <a href="/login">Pieslēgties</a>
        <a href="/register">Reģistrēties</a>
    @endauth
</header>


<main>

    <section>
        <h2>Uzticama aprūpe Tavam mīlulim</h2>

        <p>
            ĶepuDraugs.lv ir tīmekļa lietotne, kas palīdz
            mājdzīvnieku īpašniekiem atrast uzticamus
            mājdzīvnieku pieskatītājus.
        </p>
    </section>


    <section>
        <h2>Par ĶepuDraugs.lv</h2>

        <p>
            Mūsu mērķis ir padarīt mājdzīvnieku pieskatītāja
            atrašanu vienkāršāku, ērtāku un pārskatāmāku.
        </p>

        <p>
            Platformā lietotāji varēs apskatīt pieskatītāju
            informāciju, uzzināt par viņu pieredzi un izmantot
            rezervāciju un saziņas iespējas.
        </p>
    </section>


    <section>
        <h2>Kam paredzēta lietotne?</h2>

        <h3>🐶 Mājdzīvnieku īpašniekiem</h3>

        <p>
            Ērts veids, kā atrast piemērotu cilvēku,
            kas parūpēsies par viņu mājdzīvnieku.
        </p>


        <h3>🐾 Mājdzīvnieku pieskatītājiem</h3>

        <p>
            Iespēja piedāvāt savus pakalpojumus,
            veidot profilu un iegūt jaunus klientus.
        </p>


        <h3>⚙️ Administratoram</h3>

        <p>
            Iespēja pārvaldīt lietotājus un
            uzraudzīt sistēmas darbību.
        </p>
    </section>

</main>


<footer>
    <p>© {{ date('Y') }} ĶepuDraugs.lv</p>
</footer>
```

</body>
</html>
