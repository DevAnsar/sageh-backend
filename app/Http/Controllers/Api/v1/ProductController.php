<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CategoryResource;
use App\Http\Resources\v1\ProductCollection;
use App\Http\Resources\v1\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Search\ProductSearch;
use http\Env\Response;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        try {

            $paginate = 3;
            if ($request->has('paginate') && $request->input('paginate') != 0) {
                $paginate = $request->input('paginate');
            }

            $category=null;
            if ($request->has('category_slug')){
                $category_slug=$request->input('category_slug');
                $category=Category::where('slug','=',$category_slug)->first();
                if (!$category){$category=null;}
            }


            $search = new ProductSearch($category, $paginate);
            $products = $search->getSearchForClient($request, ['gallery', 'user','category']);
           return response()->json([
               'status'=>true,
               'products'=>new ProductCollection($products),
               'category'=>new CategoryResource($category),
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
    public function getProduct($product_slug)
    {
        try {


            $product = Product::where('slug',$product_slug)->first();

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
