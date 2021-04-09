<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *      version="1.1.0",
 *      title="Biilche.ir",
 *      description="Biilche Application API",
 *      @OA\Contact(
 *          email="ansaramman@gmail.com"
 *      ),
 * )
 *
 * @OA\Server(
 *      url="http://admin.biilche.ir/api/v1",
 *      description="Version 1"
 * )
 *
 */
//http://127.0.0.1:8000/api/v1
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
    public function customResponse($status,$message='',array $extra=[])
    {

        $data=[
            'status' => $status,
            'message' => $message,
        ];

        if (sizeof($extra)>0){
            $data=array_merge($data,$extra);
        }
        return response()->json($data,200);

    }
}
