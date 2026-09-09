<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mans pieskatītāja profils - ĶepuDraugs.lv</title>
</head>

<body>

    <h1>🐾 ĶepuDraugs.lv</h1>

    <h2>Mans pieskatītāja profils</h2>

    <p><strong>Pilsēta:</strong> {{ $profile->city }}</p>

    <p><strong>Par sevi:</strong> {{ $profile->description ?? 'Nav norādīts' }}</p>

    <p><strong>Pieredze:</strong> {{ $profile->experience ?? 'Nav norādīta' }}</p>

    <p><strong>Cena par dienu:</strong> {{ $profile->price }} €</p>

    <p><strong>Pieskatāmie dzīvnieki:</strong> {{ $profile->accepted_animals }}</p>

    <br>

    <a href="/dashboard">Atpakaļ uz paneli</a>

</body>
</html>