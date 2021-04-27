<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProductCollection;
use App\Http\Resources\v1\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Search\ProductSearch;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        try {

            $category=null;
            if ($request->has('category_id') && is_numeric($request->input('category_id'))){
                $category_id=$request->input('category_id');
                $category=Category::find($category_id);
            }


            $search = new ProductSearch($category, 3);
            $products = $search->getSearchForClient($request, ['gallery', 'user','category']);
           return response()->json([
               'status'=>true,
               'products'=>new ProductCollection($products)
           ]);
//           }else{
//               return response()->json([
//                   'status'=>false,
//                   'categories'=>'دسته بندی یافت نشد'
//               ]);
//           }


        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
    public function getProduct($product_id)
    {
        try {


            $product = Product::find($product_id);

            if ($product) {
                return response()->json([
                    'status' => true,
                    'product' =>new ProductResource($product)
                ]);
            } else {
                return $this->customResponse(false, 'محتوای مورد نظر یافت نشد');
            }


        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
}
