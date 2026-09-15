```blade
<nav>
    <div>
        <a href="/dashboard">🐾 ĶepuDraugs.lv</a>
    </div>

    <div>
        <a href="/dashboard">Sākums</a>
        <a href="/profile">Mans profils</a>
        <a href="/sitters">Pieskatītāji</a>
        <a href="/pets">Mani mājdzīvnieki</a>
        <a href="/bookings">Manas rezervācijas</a>

        <form action="/logout" method="POST" style="display: inline;">
            @csrf
            <button type="submit">Iziet</button>
        </form>
    </div>
</nav>

<hr>
```
