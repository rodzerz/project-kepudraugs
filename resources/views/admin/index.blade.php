<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administrators - ĶepuDraugs.lv</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="container">

        <h1>🐾 ĶepuDraugs.lv administrēšana</h1>

        <p>
            Sveiki, {{ Auth::user()->name }}!
        </p>

        @if (session('success'))
            <p>
                {{ session('success') }}
            </p>
        @endif

        @if (session('error'))
            <p>
                {{ session('error') }}
            </p>
        @endif

        <h2>Reģistrētie lietotāji</h2>

        @if ($users->count() > 0)

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Vārds</th>
                        <th>E-pasts</th>
                        <th>Loma</th>
                        <th>Reģistrēts</th>
                        <th>Statuss</th>
                        <th>Darbība</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($users as $user)

                        <tr>
                            <td>{{ $user->id }}</td>

                            <td>
                                {{ $user->name }}
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                                {{ $user->role }}
                            </td>

                            <td>
                                {{ $user->created_at->format('d.m.Y') }}
                            </td>

                            <td>
                                @if ($user->is_blocked)
                                    🚫 Bloķēts
                                @else
                                    ✅ Aktīvs
                                @endif
                            </td>

                            <td>

                                @if ($user->id !== Auth::id())

                                    <form
                                        action="/admin/users/{{ $user->id }}/toggle-block"
                                        method="POST"
                                    >
                                        @csrf

                                        <button type="submit">
                                            @if ($user->is_blocked)
                                                🔓 Atbloķēt
                                            @else
                                                🚫 Bloķēt
                                            @endif
                                        </button>
                                    </form>

                                @else

                                    <span>👑 Administrators</span>

                                @endif

                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>

        @else

            <p>
                Nav reģistrētu lietotāju.
            </p>

        @endif

    </div>

</body>
</html>