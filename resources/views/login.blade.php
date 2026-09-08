<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pieslēgšanās - ĶepuDraugs.lv</title>
</head>

<body>

    <h1>🐾 ĶepuDraugs.lv</h1>

    <h2>Pieslēgšanās</h2>


@if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif


    <form method="POST" action="/login">

        @csrf

        <div>
            <label>E-pasts</label>
            <input type="email" name="email" required>
        </div>

        <br>

        <div>
            <label>Parole</label>
            <input type="password" name="password" required>
        </div>

        <br>

        <button type="submit">Pieslēgties</button>

    </form>

</body>
</html>