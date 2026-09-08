<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Īpašnieka panelis - ĶepuDraugs.lv</title>
</head>

<body>

    <h1>🐾 ĶepuDraugs.lv</h1>

    <h2>Sveiks, {{ auth()->user()->name }}!</h2>

    <p>Šis ir mājdzīvnieka īpašnieka panelis.</p>

    <hr>

    <h3>Manas iespējas</h3>

    <ul>
        <li>Mans profils</li>
        <li>Mani mājdzīvnieki</li>
        <li>Meklēt pieskatītāju</li>
        <li>Manas rezervācijas</li>
    </ul>

    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Iziet</button>
    </form>

</body>
</html>