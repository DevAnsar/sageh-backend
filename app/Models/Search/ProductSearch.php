<?php

namespace App\Models\Search;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class ProductSearch
{
    use HasFactory;

    public $category=null;
    public $products = [];
    public $string = '?';
    protected $paginate;

    public function __construct(Category $category=null, $paginate = 10)
    {
        if ($category != null){
            $this->category=$category;
        }
        $this->category = $category;
        $this->paginate = $paginate;
    }

    public function getSearch(Request $request, $with = [])
    {

//        $skills=explode(',',$skills);
//        $skills=array_filter($skills);

        if ($this->category != null){
            $products=$this->category->products()->orderBy('created_at','DESC');
        }else{
            $products = Product::query()->orderBy('created_at','DESC');

        }

        if(inTrashed($request))
        {

            $products=$products->onlyTrashed();
            $this->string=create_paginate_url($this->string,'trashed=true');
        }
        if(isset($request['string']) && !empty($request['string']))
        {
            $searchValues = preg_split('/\s+/', $request['string']);
            $products->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->where('name', 'like', '%' . $value . '%')
                        ->orWhere('family', 'like', '%' . $value . '%')
                        ->orWhere('productname', 'like', '%' . $value . '%');
                }
            });
//            $products=$products->where('name','like','%'.$request['string'].'%');
//            $products=$products->orWhere('family','like','%'.$request['string'].'%');
            $this->string=create_paginate_url($this->string,'string='.$request['string']);
        }

        foreach ($with as $item) {
            if ($item != '') {
                $products->with($item);
            }
        }

//        if ($this->category_id != 0) {
//            $products->whereHas('categories', function ($q) {
//                $q->where('id', $this->category_id);
//            });
//        }
//        if (sizeof($skills)>0){
//            $products->whereHas('skills',function ($q) use ($skills){
//                $q->whereIn('id',$skills);
//            });
//        }

//        if ($string != null || $string != '') {
//            $searchValues = preg_split('/\s+/', $string);
//            $products->where(function ($q) use ($searchValues) {
//                foreach ($searchValues as $value) {
//                    $q->where('name', 'like', '%' . $value . '%')
//                        ->orWhere('family', 'like', '%' . $value . '%')
//                        ->orWhere('productname', 'like', '%' . $value . '%');
//                }
//            });
//        }



        $products=$products->paginate($this->paginate);
        $products=$products->withPath($this->string);
        $this->products = $products;

        return $products;
    }

    public function getResults()
    {

        $products=$this->products->paginate($this->paginate);

        return $products;
    }

    public function getSearchForClient(Request $request, $with = [])
    {

        if ($request->has('category_id') && !empty($request->input('category_id')) && $request->input('category_id') != 0 ) {
            $category_id=$request->input('category_id');
            $category=Category::find($category_id);
            if ($category){
                $products=$category->products();
            }else{
                $products = Product::query();
            }
        }
        else{
            $products = Product::query();
        }

        if ($request->has('order_by') && $request->input('order_by')!=''){
            $order_by=$request->input('order_by');

            switch ($order_by){
                case 'ASC':

                    $products=$products->orderBy('created_at','ASC');
                    break;
                case 'DESC':
                    $products=$products->orderBy('created_at','DESC');
                    break;
                default:
                    $products=$products->orderBy('created_at','DESC');
                    break;
            }
        }else{
            $products=$products->orderBy('created_at','DESC');
        }

        if ($request->has('city_id') && is_numeric($request->input('city_id')) && $request->input('city_id')!=0){
            $products=$products->where('city_id','=',$request->input('city_id'));
        }
        if ($request->has('user_id') && is_numeric($request->input('user_id')) && $request->input('user_id')!=0){
            $products=$products->where('user_id','=',$request->input('user_id'));
        }

        if(isset($request['string']) && !empty($request['string']))
        {
            $searchValues = preg_split('/\s+/', $request['string']);
            $products->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->where('content', 'like', '%' . $value . '%');
                }
            });
        }


        foreach ($with as $item) {
            if ($item != '') {
                $products->with($item);
            }
        }



        $products=$products->paginate($this->paginate);
//        $products=$products->withPath($this->string);
        $this->products = $products;

        return $products;
    }
}
