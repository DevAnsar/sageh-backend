@php
if (!$url || $url==null){
    $url='/images/noImage.png';
}
@endphp

<img class="vitrin-img " style="color: white" src="{{$url}}">
