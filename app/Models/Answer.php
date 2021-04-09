<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @OA\Schema(
 *     title="Answer",
 *     description="Answer model",
 *     @OA\Xml(
 *         name="Answer"
 *     )
 * )
 */
class Answer extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'user_id',
        'question_id',
        'content',
        'likeCount',
        'dislikeCount',
        'status',
    ];
    public function user(){
        return $this->belongsTo('\App\Models\User','user_id','id');
    }
    public function images(){
        return $this->morphMany('\App\Models\File','fileable');
    }
    public function question(){
        return $this->belongsTo(Question::class,'id','question_id');
    }
}
