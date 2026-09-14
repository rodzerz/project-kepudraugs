```blade
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pieskatītāja panelis - ĶepuDraugs.lv</title>
</head>

<body>

    <x-sitter-nav />

    <h2>Sveiks, {{ auth()->user()->name }}!</h2>

    <p>Šis ir mājdzīvnieku pieskatītāja panelis.</p>

</body>
</html>
```
