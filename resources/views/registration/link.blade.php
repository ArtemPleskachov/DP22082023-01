<!DOCTYPE html>
<html>
<head>
    <title>Unique Link</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href=" {{ asset('/css/main.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

</head>
<body class="linkPage">
<div class="lucky">
    <table>
        <tr>
            <td>Hello</td>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <td>Your lucky link</td>
            <td><a href="{{ route('pages.pageA', ['link' => $user->unique_link]) }}">{{ $user->unique_link }}</a></td>
        </tr>
        <tr>
            <td>The link expires in</td>
            <td>{{ $expirationDate }}</td>
        </tr>
    </table>
</div>
</body>
</html>