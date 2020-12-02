<!--
    $errcode 1 : can't find uri parameter
    $errcode 2 : uri is not youtube.com
-->

{{-- {{dd($retData)}} --}}
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>YT MusicBank</title>
        <style>
            body {
            background: #2ecc71;
            font-size: 62.5%;
          }
          
          button,
          button::after {
            -webkit-transition: all 0.3s;
              -moz-transition: all 0.3s;
            -o-transition: all 0.3s;
              transition: all 0.3s;
          }
          
          button {
            background: none;
            border: 3px solid #fff;
            border-radius: 5px;
            color: #fff;
            display: block;
            font-size: 1.6em;
            font-weight: bold;
            margin: 1em auto;
            padding: 2em 6em;
            position: relative;
            text-transform: uppercase;
          }
          
          button::before,
          button::after {
            background: #fff;
            content: '';
            position: absolute;
            z-index: -1;
          }
          
          .button:hover {
            color: #2ecc71;
          }
          
          /* BUTTON 5 */
          .btn-5 {
            overflow: hidden;
          }
          
          .btn-5::after {
            /*background-color: #f00;*/
            height: 100%;
            left: -35%;
            top: 0;
            transform: skew(50deg);
            transition-duration: 0.6s;
            transform-origin: top left;
            width: 0;
          }
          
          .btn-5:hover:after {
            height: 100%;
            width: 135%;
          }
          /* youtube플레이어 화면에 꽉차게 하는 css */
            #youTubePlayer1 {position:relative;width:100%;padding-bottom:56.25%;}
            #youTubePlayer1 iframe {position:absolute;width:100%;height:100%;}
            </style>





</head>
    <body>
        @csrf

        <div id="youTubePlayer1"></div>
        <!--
        <button class="btn-5">Button 5</button>
        <input type="checkbox" name="filetype" value="mp3">
        <input class="btn-5" type="button" name="filetype" value="mp4">
        -->
        <form>
            <input type="hidden" id="youtube_id" name="youtube_id">
            <input type="text" name="filetype">
            <input type="submit">
        </form>

        {{-- YoutubeIdSplitter --}}
        <script type="text/javascript">
            var uri = "{{$retData['uri']}}";   
            var temp_youtube_id = uri.split('v=');
            var youtube_id = temp_youtube_id[1].substr(0, 11);
            //document.write(youtube_id);
            document.getElementById('youtube_id').value=youtube_id;
        </script>
        {{-- YoutubePlayer --}}
        <script type="text/javascript" src="/js/youtubeplayer.js">
        
        </script>
    </body>
</html>