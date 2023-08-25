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
            <form class="generate" action="{{ route('pages.generate', ['link' => $user->unique_link]) }}" method="get">
                <button class="generate" type="submit">Generate New Unique Link</button>
            </form>
        </div>
        <div class="manager-button-deactivate">
            @if (Auth::user()->unique_link)
                <form action="{{ route('pages.destroy', ['link' => $user->unique_link]) }}" method="get">
                    <button class="deactivate" type="submit">Deactivate Unique Link</button>
                </form>
            @endif
        </div>
        @if(isset($successMessage))
        <div class="result-row">
                <div class="alert alert-success">
                    {{ $successMessage }}
                </div>
        </div>
        @endif
    </div>
</div>


</body>
</html> 