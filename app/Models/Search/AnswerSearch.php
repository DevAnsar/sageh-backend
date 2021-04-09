<?php

namespace App\Models\Search;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class AnswerSearch
{
    use HasFactory;

    public $question = null;
    public $answers = [];
    public $string = '?';
    protected $paginate;

    public function __construct(Question $question=null , $paginate = 10)
    {
        $this->paginate = $paginate;
        if ($question != null){
            $this->question=$question;
        }
    }

    public function getSearch(Request $request, $with = [])
    {


//        $skills=explode(',',$skills);
//        $skills=array_filter($skills);

        if ($this->question == null){
            $answers = Answer::query()->orderBy('created_at','DESC');
        }else{
            $answers = $this->question->answers()->orderBy('created_at','DESC');
        }

        if(inTrashed($request))
        {

            $answers=$answers->onlyTrashed();
            $this->string=create_paginate_url($this->string,'trashed=true');
        }
        if(isset($request['string']) && !empty($request['string']))
        {
            $searchValues = preg_split('/\s+/', $request['string']);
            $answers->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->where('content', 'like', '%' . $value . '%');
                }
            });
//            $answers=$answers->where('name','like','%'.$request['string'].'%');
//            $answers=$answers->orWhere('family','like','%'.$request['string'].'%');
            $this->string=create_paginate_url($this->string,'string='.$request['string']);
        }

        foreach ($with as $item) {
            if ($item != '') {
                $answers->with($item);
            }
        }

//        if (isset($request['category_id']) && !empty($request['category_id']) && $request['category_id'] != 0) {
//            $category_id=$request['category_id'];
//            $answers->whereHas('category', function ($q) use ($category_id) {
//                $q->where('id', $category_id);
//            });
//        }
//        if (sizeof($skills)>0){
//            $answers->whereHas('skills',function ($q) use ($skills){
//                $q->whereIn('id',$skills);
//            });
//        }

//        if ($string != null || $string != '') {
//            $searchValues = preg_split('/\s+/', $string);
//            $answers->where(function ($q) use ($searchValues) {
//                foreach ($searchValues as $value) {
//                    $q->where('name', 'like', '%' . $value . '%')
//                        ->orWhere('family', 'like', '%' . $value . '%')
//                        ->orWhere('username', 'like', '%' . $value . '%');
//                }
//            });
//        }



        $answers=$answers->paginate($this->paginate);
        $answers=$answers->withPath($this->string);
        $this->answers = $answers;

        return $answers;
    }
}
