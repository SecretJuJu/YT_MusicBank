<!--
    $errcode 1 : can't find uri parameter
    $errcode 2 : uri is not youtube.com
-->

{{-- {{dd($retData)}} --}}
<form action="/download" method="post">
    @csrf
    <input type="text" name="youtube_id">
    <input type="text" name="filetype">
    <input type="submit">
</form>