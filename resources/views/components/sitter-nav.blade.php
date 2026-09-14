```blade
<nav>

    <div>
        <a href="/dashboard">🐾 ĶepuDraugs.lv</a>
    </div>

    <div>
        <a href="/dashboard">Sākums</a>

        <a href="/sitter-profile">Mans profils</a>

        <a href="/bookings/sitter">Saņemtās rezervācijas</a>

        <form action="/logout" method="POST" style="display: inline;">
            @csrf

            <button type="submit">
                Iziet
            </button>
        </form>
    </div>

</nav>

<hr>
```
