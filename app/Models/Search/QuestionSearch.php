<?php

namespace App\Models\Search;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class QuestionSearch
{
    use HasFactory;

    public $questions = [];
    public $string = '?';
    protected $paginate;

    public function __construct($paginate = 10)
    {
        $this->paginate = $paginate;
    }

    public function getSearch(Request $request, $with = [])
    {

//        $skills=explode(',',$skills);
//        $skills=array_filter($skills);

         $questions = Question::query()->orderBy('created_at','DESC');

        if(inTrashed($request))
        {

            $questions=$questions->onlyTrashed();
            $this->string=create_paginate_url($this->string,'trashed=true');
        }
        if(isset($request['string']) && !empty($request['string']))
        {
            $searchValues = preg_split('/\s+/', $request['string']);
            $questions->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->where('content', 'like', '%' . $value . '%');
                }
            });
//            $questions=$questions->where('name','like','%'.$request['string'].'%');
//            $questions=$questions->orWhere('family','like','%'.$request['string'].'%');
            $this->string=create_paginate_url($this->string,'string='.$request['string']);
        }

        foreach ($with as $item) {
            if ($item != '') {
                $questions->with($item);
            }
        }

        if (isset($request['category_id']) && !empty($request['category_id']) && $request['category_id'] != 0) {
            $category_id=$request['category_id'];
            $questions->whereHas('category', function ($q) use ($category_id) {
                $q->where('id', $category_id);
            });
        }
//        if (sizeof($skills)>0){
//            $questions->whereHas('skills',function ($q) use ($skills){
//                $q->whereIn('id',$skills);
//            });
//        }

//        if ($string != null || $string != '') {
//            $searchValues = preg_split('/\s+/', $string);
//            $questions->where(function ($q) use ($searchValues) {
//                foreach ($searchValues as $value) {
//                    $q->where('name', 'like', '%' . $value . '%')
//                        ->orWhere('family', 'like', '%' . $value . '%')
//                        ->orWhere('username', 'like', '%' . $value . '%');
//                }
//            });
//        }



        $questions=$questions->paginate($this->paginate);
        $questions=$questions->withPath($this->string);
        $this->questions = $questions;

        return $questions;
    }


    public function getSearchForClient(Request $request, $with = [])
    {

        if ($request->has('category_id') && !empty($request->input('category_id')) && $request->input('category_id') != 0 ) {
            $category_id=$request->input('category_id');
            $category=Category::find($category_id);
            if ($category){
                $questions=$category->questions();
            }else{
                $questions = Question::query();
            }
        }
        else{
            $questions = Question::query();
        }

         if ($request->has('order_by') && $request->input('order_by')!=''){
             $order_by=$request->input('order_by');

             switch ($order_by){
                 case 'ASC':

                     $questions=$questions->orderBy('created_at','ASC');
                     break;
                 case 'DESC':
                     $questions=$questions->orderBy('created_at','DESC');
                     break;
                 default:
                     $questions=$questions->orderBy('created_at','DESC');
                     break;
             }
         }else{
             $questions=$questions->orderBy('created_at','DESC');
         }

         if ($request->has('city_id') && is_numeric($request->input('city_id')) && $request->input('city_id')!=0){
            $questions=$questions->where('city_id','=',$request->input('city_id'));
         }

        if(isset($request['string']) && !empty($request['string']))
        {
            $searchValues = preg_split('/\s+/', $request['string']);
            $questions->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->where('content', 'like', '%' . $value . '%');
                }
            });
        }


        foreach ($with as $item) {
            if ($item != '') {
                $questions->with($item);
            }
        }



        $questions=$questions->paginate($this->paginate);
//        $questions=$questions->withPath($this->string);
        $this->questions = $questions;

        return $questions;
    }
}
