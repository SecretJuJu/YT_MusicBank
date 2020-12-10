<!--
    $errcode 1 : can't find uri parameter
    $errcode 2 : uri is not youtube.com
    $errcode 3 : not available url
-->
@if($retData['result'] == false)
  <script>
  @if($retData['errcode'] == 1)
    alert("please input youtube url")
  @endif
  @if($retData['errcode'] == 2)
    alert("this is not youtube url")
  @endif
  @if($retData['errcode'] == 3)
    alert("this link is not available")
  @endif
  location.href="/";
  </script>

@else 



{{-- {{dd($retData)}} --}}
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>YT MusicBank</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="/css/search.css"/>
</head>
    <body>
    @include('layouts.app')
        @csrf
        <div class="main">
          <div id="youTubePlayer1"></div>
          <div class="donwload">
            <div class="status">
              <div class="converting">Converting...</div>
            </div>
            <div class="buttons">
              <div class="setCenter">
                <button onclick="converting('mp3')">MP3</button>
                <button onclick="converting('mp4')">MP4</button>
              </div>
            </div>
          </div>
        </div>
        
        <!--
        <button class="btn-5">Button 5</button>
        <input type="checkbox" name="filetype" value="mp3">
        <input class="btn-5" type="button" name="filetype" value="mp4">
        -->
        <form action="/download" method="post">
          @csrf
          <input type="text" name="filetype">
          <input type="text" name="youtube_id">
          <input type="submit" value="제출">
        </form>
        
        {{-- YoutubePlayer --}}
        <script type="text/javascript" src="/js/youtubeplayer.js"></script>


        <script type="text/javascript">
          var uri = "{{$retData['uri']}}";   
          var temp_youtube_id = uri.split('v=');
          var youtube_id = temp_youtube_id[1].substr(0, 11);
          //document.write(youtube_id);
          document.getElementById('youtube_id').value=youtube_id;
          

          function converting (filetype) {
            $(".converting").css("display", "block")
            $(".converting").html("Converting...")
            $.ajax({
                  //아래 headers에 반드시 token을 추가해줘야 한다.!!!!! 
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  type: 'post',
                  url: '/download',
                  dataType: 'json',
                  data: { "youtube_id" : youtube_id , "filetype":filetype },
                  success: function(data) {
                    console.log(data)
                    if(data.result) {
                      @if (!Auth::check())
                      $(".converting").html(" <a href=\"/media/"+filetype+"/"+youtube_id+"."+filetype+"\" id=\"downloadBtn\"download=\""+data.name+"."+filetype+"\">Download</a>");
                      @else  
                      $(".converting").html(" <a href=\"/media/"+filetype+"/"+youtube_id+"."+filetype+"\" id=\"downloadBtn\"download=\""+data.name+"."+filetype+"\" onclick=\"logging(\'"+filetype+"\')\">Download</a>");
                      @endif
                    }else {
                      $(".converting").html("Failed")
                    }
                      
                  },
                  error: function(data) {
                        console.log(data);
                  }
            });
          }
          function logging(filetype){
            console.log({ "youtube_id" : youtube_id , "filetype":filetype })
            $.ajax({
                  //아래 headers에 반드시 token을 추가해줘야 한다.!!!!! 
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  type: 'post',
                  url: '/logging',
                  dataType: 'json',
                  data: { "youtube_id" : youtube_id , "filetype":filetype },
                  success: function(data) {
                    console.log(data)
                  },
                  error: function(data) {
                        console.log(data);
                  }
            });
          }
        </script>
    </body>
</html>

@endif