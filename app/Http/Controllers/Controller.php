<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function exceptionResponse(\Exception $exception,$message='')
    {

        return response()->json([
            'status' => false,
            'message' => $message,
            'error' => $exception->getMessage(),
        ],200);

    }
    public function customResponse($status,$message='',array $extra=[],array $errors=[])
    {

        $data=[
            'status' => $status,
            'message' => $message,
            'errors'=>$errors
        ];

        if (sizeof($extra)>0){
            $data=array_merge($data,$extra);
        }
        return response()->json($data,200);

    }
}
