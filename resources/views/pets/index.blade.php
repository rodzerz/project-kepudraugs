<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mani mājdzīvnieki - ĶepuDraugs.lv</title>
</head>

<body>

    <x-owner-nav />

    <h2>Mani mājdzīvnieki</h2>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($pets->count() > 0)

        @foreach ($pets as $pet)

            <div>
                <h3>{{ $pet->name }}</h3>

                <p>
                    <strong>Veids:</strong>
                    {{ $pet->species }}
                </p>

                <p>
                    <strong>Šķirne:</strong>
                    {{ $pet->breed ?? 'Nav norādīta' }}
                </p>

                <p>
                    <strong>Vecums:</strong>
                    {{ $pet->age ?? 'Nav norādīts' }}
                </p>

                <p>
                    <strong>Svars:</strong>
                    {{ $pet->weight ?? 'Nav norādīts' }} kg
                </p>

                <p>
                    <strong>Īpašās prasības:</strong>
                    {{ $pet->special_requirements ?? 'Nav norādītas' }}
                </p>
            </div>

            <hr>

        @endforeach

    @else

        <p>Tev vēl nav pievienotu mājdzīvnieku.</p>

    @endif

    <a href="/pets/create">+ Pievienot mājdzīvnieku</a>

</body>
</html>