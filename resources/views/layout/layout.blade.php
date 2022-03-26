<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="{{$generateBase()}}">
    <title>I5NET</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix("css/app.css") }}" type="text/css">

</head>
<body id="body">
    <main class="overflow-hidden relative h-screen w-screen bg-gray-50">
        @include("components.navbar")

        <div class="w-full h-full px-5 md:px-0">
            @yield("content")
        </div>
    </main>
    <script src="{{ mix("js/app.js") }}" defer></script>
</body>
</html>