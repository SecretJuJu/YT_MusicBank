<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My downloads</title>
</head>

    <body>
        @include('layouts.app')

        <div>
            
                <div class="log_box">
                    <div>
                    <table style="border-top: 1px solid #444444; border-bottom: 1px solid #444444;border-collapse: collapse;">
                            <tr style="border-bottom:3px solid rgba(0,0,0,0.4);">
                                <th style="width: 60%;font-size: 30px; text-align: left;">Video Title</th>
                                <th style="width: 10%;font-size: 30px;">Size</th>
                                <th style="width: 10%;font-size: 30px;">format</th>
                                <th style="width: 10%;font-size: 30px;">Download</th>
                            </tr>
                            @foreach ($retData['infos'] as $info)
                                <tr style="margin-top:5px">
                                    <td style="width: 60%; text-align: left;">{{ $info -> name}}</td>
                                    <td style="width: 10%;">{{$info->file_size}}kb</td>
                                    <td style="width: 10%;">{{$info->file_type}}</td>
                                    <td style="width: 10%;"><a download="{{$info->name}}" href="/media/{{$info->file_type}}/{{$info->youtube_id}}.{{$info->file_type}}" >Download</a></td>
                                </tr>
                            @endforeach
                    </table>
                    </div>
                </div>
            
        </div>
    </body>
</html>