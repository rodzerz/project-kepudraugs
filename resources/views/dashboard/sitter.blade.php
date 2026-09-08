<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pieskatītāja panelis - ĶepuDraugs.lv</title>
</head>

<body>

    <h1>🐾 ĶepuDraugs.lv</h1>

    <h2>Sveiks, {{ auth()->user()->name }}!</h2>

    <p>Šis ir mājdzīvnieku pieskatītāja panelis.</p>

    <hr>

    <h3>Manas iespējas</h3>

    <ul>
        <li>Mans profils</li>
        <li>Mani pakalpojumi</li>
        <li>Manas rezervācijas</li>
        <li>Manas atsauksmes</li>
    </ul>

    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Iziet</button>
    </form>

</body>
</html>