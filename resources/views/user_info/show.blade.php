helloworld   <br>
{{--
    $infos : array  
    $info -> user_id 
    $info -> youtube_id
    $info -> file_hash
    $info -> created_at
    $info -> name
    $info -> path
    $info -> file_size
    $info -> file_type
--}}

@foreach ($infos as $info)
    <p>
        name : {{ $info -> name }} <br>
        file size : {{ $info->file_size}}kb <br>
    </p>
@endforeach