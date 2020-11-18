<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>YT MusicBank</title>
    </head>
    <body>
        @if (Auth::check())
            loggined
        @else
            not loggined
        @endif
    </body>
</html>