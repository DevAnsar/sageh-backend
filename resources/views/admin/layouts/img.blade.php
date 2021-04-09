@php
if (!$url || $url==null){
    $url='/images/loading-image.svg';
}else{
$url='/storage/'.$url;
}
@endphp

<img class="vitrin-img" src="{{$url}}">