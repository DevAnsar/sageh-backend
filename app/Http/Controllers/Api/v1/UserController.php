<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProductCollection;
use App\Http\Resources\v1\UserProfileResource;

use App\Models\User;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

use GuzzleHttp\Client;

class UserController extends Controller
{

    public function my_ips(){

        $client = new Client();

        try {
             $response = $client->request('GET', 'http://localhost:4000/my_ip');

             return $response->getBody();
//            return response()->json([
//                "status"=>true,
//                "response"=>$response
//            ]);
        } catch (GuzzleException $e) {
            return $this->customResponse(false,$e->getMessage());
        }
    }

    public function setCategory(Request $request)
    {
        try {

            if ($request->has('category_id') && is_numeric($request->input('category_id'))){
                $category_id=$request->input('category_id');
                $user=auth('api')->user();
                $user->categories()->sync([$category_id]);
                return $this->customResponse(true,'دسته ی شغلی شما ثبت شد');
            }else{
                return $this->customResponse(false,'آیدی دسته الزامی است');

            }


        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception,'مشکلی پیش آمد. دوباره تلاش کنید');
        }
    }
    public function getUsers($category_id, Request $request)
    {
        try {

//           $category=Category::find($category_id);

            $search = new UserSearch($category_id, 3);
            return $products = $search->getSearch($request->skills, $request->input('search'));
//           return response()->json([
//               'status'=>true,
//               'products'=>$products
//           ]);
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

    public function getUser($user_id,Request $request)
    {
        try {
            $user = User::where('id', $user_id)->first();
            $client=$request->user();
            if ($user) {
                $thisHasMyAccount=$client ? ($user->id==$client->id?true:false):false;
                $data=new UserProfileResource($user,$thisHasMyAccount);
                return response()->json($data);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'کاربر یافت نشد'
                ]);
            }
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
    public function getProducts($user_id,Request $request)
    {
        try {
            $user = User::where('id', $user_id)->first();
            if ($user) {
                $products=$user->products()->latest()->paginate(1);
//                dd($products) ;
                $data=new ProductCollection($products);
                return response()->json($data);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'کاربر یافت نشد'
                ]);
            }
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

}
