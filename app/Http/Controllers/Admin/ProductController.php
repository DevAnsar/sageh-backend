<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Search\ProductSearch;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends MainController
{
    protected $model = Product::class;
    protected $title = 'محصول';
    protected $route_params = 'products';

    public function route_params($data){
//        foreach ($data as $d){
//            $this->route_params=$this->route_params . 'questions/'.$d.'/answers';
//        }
        return $this->route_params;
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category=Category::find($request['category_id']);
        $products_search=new ProductSearch($category,5);
        $products=$products_search->getSearch($request,['image']);
        $trash_product_count = Product::onlyTrashed()->count();
        $allCategories=Category::oldest()->select(['id','title'])->with(['icon'])->get();
        return view('admin.data.products.index', compact('products', 'request', 'trash_product_count','allCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users=User::oldest()->get();
        $categories=Category::oldest()->get();
        return view('admin.data.products.create',compact('categories','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:1',
        ]);

        try {
            $inputs = $request->all();
            $product = Product::create($inputs);

            if ($request->hasFile('image')) {
                $image=uploadImage($request, "products/$product->slug/image", 'image');
                $product->image()->create(['url' => $image['url'], 'type' => 'image']);
            }
            return redirect(route('admin.products.index'));

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $users=User::oldest()->get();
        $categories=Category::oldest()->get();
        return view('admin.data.products.edit', compact('product','categories','users'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Product $product)
    {
//        return deleteImage($product->icon->url);
//        return $product->icon->url;
        $this->validate($request, [
            'title' => 'required|min:1',
        ]);

        try {
            $inputs = $request->all();
            $product->update($inputs);

            if ($request->file('image')) {

                $res = uploadImage($request->file('image'), "/products/$product->id/image", 'image');
                if ($res['status']) {
                    if ($product->image) {
                        deleteImage($product->image['url']);
                        $product->image()->update(['url' => $res['url'], 'name' => $res['name']]);
                    } else {
                        $product->image()->create(['url' => $res['url'], 'name' => $res['name'], 'type' => 'image']);
                    }
                }
            }


            return redirect(route('admin.products.index'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function store_skills($product_id,Request $request){
//        return $request->data;

        try{
            $skills_id=array_filter(explode(',',$request->data));
            $product=Product::find($product_id);
            if ($product){
                $product->skills()->sync($skills_id);
            }
            return response()->json([
                'status'=>true,
                'message'=>'مهارت شغلی مرتبط ، با موفق برای محصول ثبت شد'
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status'=>false,
                'message'=>$exception->getMessage()
            ]);
        }

    }
}
