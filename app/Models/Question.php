<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @OA\Schema(
 *     title="Question",
 *     description="Question model",
 *     @OA\Xml(
 *         name="Question"
 *     )
 * )
 */
class Question extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
      'user_id',
      'content',
      'category_id',
      'best_answer_id',
      'answerCount',
      'likeCount',
      'dislikeCount',
      'status',
    ];


//    public static function getData($request,$with=[])
//    {
//        $string='?';
//        $questions=self::orderBy('created_at','DESC');
//        if(inTrashed($request))
//        {
//            $questions=$questions->onlyTrashed();
//            $string=create_paginate_url($string,'trashed=true');
//        }
//        if(isset($request['string']) && !empty($request['string']))
//        {
//            $questions=$questions->where('name','like','%'.$request['string'].'%');
//            $questions=$questions->orWhere('family','like','%'.$request['string'].'%');
//
//            $searchValues = preg_split('/\s+/', $request['string']);
//            $questions->where(function ($q) use ($searchValues) {
//                foreach ($searchValues as $value) {
//                    $q->where('content', 'like', '%' . $value . '%');
//                }
//            });
//
//            $string=create_paginate_url($string,'string='.$request['string']);
//        }
//        foreach ($with as $item){
//            if ($item!=''){
//                $questions->with($item);
//            }
//        }
//        $questions=$questions->paginate(10);
//        $questions->withPath($string);
//        return $questions;
//    }

    public function images(){
        return $this->morphMany('\App\Models\File','fileable');
    }
    public function user(){
        return $this->belongsTo('\App\Models\User','user_id','id');
    }

    public function answers(){
        return $this->hasMany(Answer::class,'question_id','id');
    }
    public function best_answer(){
        return $this->hasOne(Answer::class,'id','best_answer_id');
    }
    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }

//    public function skills()
//    {
//        return $this->belongsToMany('App\Models\Skill','question_skills','question_id','skill_id');
//    }
}
