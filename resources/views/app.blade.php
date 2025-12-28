<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" href="{{ asset('images/favicon-32x32.png') }}">

    @vite('resources/js/app.js')
    {{-- @vite('resources/scss/index.scss') --}}
    @inertiaHead
    @routes
</head>
<body>
    @inertia
</body>
</html>
