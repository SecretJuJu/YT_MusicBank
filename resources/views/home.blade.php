<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>YT MusicBank</title>
    </head>
    <body>
        @include('layouts.app')
        @if (Auth::check())
            
        @else
            
        @endif
        <div id="main-logo">
            img
        </div>
        <div id="search">
            <form action="/search" method="get">
                <div class="form-box">  
                    <input id="search-box" type="text" placeholder="Type Youtube URL" name="uri">
                    <input id="search-button" type="submit" value="SEARCH">
                </div>
            </form>
        </div>

    </body>
</html>
