<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Random Game Registration</title>
    <link rel="stylesheet" type="text/css" href=" {{ asset('/css/main.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <form action="{{ route('registration.store') }}" method="post">
        @csrf
        <label>Login</label>
        <input type="text" name="name" placeholder="Enter your name">
        <label>Phone</label>
        <input type="tel" name="phone" placeholder="Enter your phone">
        <button type="submit">Register</button>
    </form>
</body>
</html>