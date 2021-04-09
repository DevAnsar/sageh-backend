<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

function biilche_route($route_param, $controller, $except = [], $config = [])
{

    Route::post($route_param . '/destroy_items',$controller .'@destroy_items')->name($route_param . '.destroy_items');
    Route::post($route_param . '/restore_items',$controller .'@restore_items')->name($route_param . '.restore');
    Route::post($route_param . '/{id}',$controller . '@restore')->name($route_param . '.restore');
    Route::resource($route_param,$controller, $config)->except($except);
}
function create_paginate_url($string, $text)
{
    if ($string == '?') {
        $string = $string . $text;
    } else {
        $string = $string . '&' . $text;
    }
    return $string;
}
function inTrashed($req)
{
    if (isset($req['trashed']) && $req['trashed'] == 'true') {
        return true;
    } else {
        return false;
    }
}

function uploadImage(Request $request,$dir='',$name=''){
    if ($request->hasFile($name)) {
        if ($request->file($name)->isValid()) {
            $file_name= $request->file($name)->getClientOriginalName();
            $request->file($name)->storeAs($dir, $file_name,['disk'=>'public']);
            $url = $dir.'/'.$file_name;
            return [
                'status'=>true,
                'url'=>$url,
                'name'=>$file_name
            ];
        }
    }
    return [
        'status'=>false,
        'message'=>''
    ];
}
function deleteImage($dir){

//    return $dir;
    if (Storage::exists('/public/'.$dir)){
        Storage::delete('/public/'.$dir);
        return true;
    }
    return false;
}
function getImage($dir){
    if (Storage::exists('/public/'.$dir)){
        return Storage::url($dir);
    }
    return false;
}

function userFullName($user){
    return $user->name.' '.$user->family;
}
function isMobile($mobile){
    return preg_match('/^[0-9]{11}+$/', $mobile);
//    return true;
}

function generateRandomNumber($length=8){
    $random = "";
    srand((double)microtime() * 1000000);

    $data = "102345601234567899876543210890";

    for ($i = 0; $i < $length; $i++) {
        $random .= substr($data, (rand() % (strlen($data))), 1);
    }

    return $random;
}

function generateRandomString($length = 8)
{
    $random = "";
    srand((double)microtime() * 1000000);
    $data = "AKDETDGFBCIATWBKDJFNVBCHYEJSKAUEHDFZQAAPOL";
    for ($i = 0; $i < $length; $i++) {
        $random .= substr($data, (rand() % (strlen($data))), 1);
    }
    return $random;
}

function generateRandomMultiString($length = 8)
{
    $random = "";
    srand((double)microtime() * 1000000);

    $data = "123456123456789071234567890890";
    $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz"; // if you need alphabatic also

    for ($i = 0; $i < $length; $i++) {
        $random .= substr($data, (rand() % (strlen($data))), 1);
    }

    return $random;

}

function replace_number($number)
{
    $number = str_replace("0", '۰', $number);
    $number = str_replace("1", '۱', $number);
    $number = str_replace("2", '۲', $number);
    $number = str_replace("3", '۳', $number);
    $number = str_replace("4", '۴', $number);
    $number = str_replace("5", '۵', $number);
    $number = str_replace("6", '۶', $number);
    $number = str_replace("7", '۷', $number);
    $number = str_replace("8", '۸', $number);
    $number = str_replace("9", '۹', $number);

    return $number;
}
function replace_number_en($number)
{
    $number = str_replace( '۰',"0", $number);
    $number = str_replace( '۱', "1",$number);
    $number = str_replace('۲',"2",  $number);
    $number = str_replace('۳',"3",  $number);
    $number = str_replace( '۴',"4", $number);
    $number = str_replace( '۵',"5", $number);
    $number = str_replace('۶',"6",  $number);
    $number = str_replace( '۷',"7", $number);
    $number = str_replace( '۸',"8", $number);
    $number = str_replace( '۹',"9", $number);

    return $number;
}

function getAccountStatus(\App\Models\User $user){


    return [
        'account_status' => $user->status ? true : false,
        'profile_status' => ($user->name == null || ($user->name == null && $user->family == null)) ? false : true,
        'password_status' => $user->password == null  ? false : true,
    ];
}