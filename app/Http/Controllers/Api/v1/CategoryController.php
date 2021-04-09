<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CategoryCollection;
use App\Models\Category;
use App\Models\Search\UserSearch;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *
     *     path="/getCategories",
     *     tags={"Category"},
     *     summary="",
     *     description="Show all job categories",
     *     @OA\Response(response="200", description="Category Collection")
     * )
     */
    public function getCategories(){
       try{
           $categories=Category::orderBy('order_number','asc')->get();

           return response()->json([
               'status'=>true,
               'categories'=>new CategoryCollection($categories)
           ]);


       }catch (\Exception $exception){
           return $this->exceptionResponse($exception);
       }
    }




}
