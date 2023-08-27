<!DOCTYPE html>
<html>
<head>
    <title>Game</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href=" {{ asset('/css/pageA.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

</head>
<body class="game-page">
<div class="container">

    <div class="manager-container">
        <div class="manager-button-generate">
            <form class="generate" action="{{ route('pages.generate', ['link' => $user->links->first()->unique_link]) }}" method="get">
                <button class="generate" type="submit">Generate New Unique Link</button>
            </form>
        </div>
        <div class="manager-button-deactivate">
            @if (Auth::user()->id)
                <form action="{{ route('pages.destroy', ['link' => $user->links->first()->unique_link]) }}" method="get">
                    <button class="deactivate" type="submit">Deactivate Unique Link</button>
                </form>
            @endif
        </div>
        @if(session('successMessage'))
        <div class="result-row">
            <div class="alert alert-success">
                    {{ session('successMessage') }}
            </div>
        </div>
        @endif
        <div class="manager-button-play">
            <form class="generate" action="{{ route('pages.startGame', ['link' => $user->links->first()->unique_link]) }}" method="get">
                <button class="generate" type="submit">Imfeelinglucky</button>
            </form>
        </div>
        @if(session('gameStart'))
        <div class="game" style="background-color: {{ session('result') === 'WIN' ? 'rgba(78, 255, 108, 0.8)' : 'rgba(207, 0, 38, 0.8)' }}">
            <h2>Your game</h2>
            <p>Random number: {{ session('randomNumber') }}</p>
            <p>Result: {{ session('result') }}</p>
            <p>Win amount: {{ session('winAmount') }}</p>
        </div>
        @endif
        <div class="manager-button-history">
            <form class="generate" action="{{ route('pages.history', ['link' => $user->links->first()->unique_link]) }}" method="get">
                <button class="generate" type="submit">History</button>
            </form>
        </div>
        @if(session('history'))
        <div class="history">
            <table>
                <thead>
                <tr>
                    <th>Result</th>
                    <th>Random Number</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                    @foreach(session('gameHistory') as $game)
                        <tr>
                            <td>{{ $game->win ? 'WIN' : 'LOSE' }}</td>
                            <td>{{ $game->random_number }}</td>
                            <td>{{ $game->amount }}</td>
                        </tr>
                   @endforeach
            </table>
        </div>
        @endif
    </div>
</div>


</body>
</html> 