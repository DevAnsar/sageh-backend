<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,Sluggable,SoftDeletes;

    protected $fillable=[
        'title',
        'slug',
        'category_id',
        'user_id',
        'description',
        'agreement',
        'price',
        'price_type',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function getData($request,$with=[])
    {
        $string='?';
        $user=self::orderBy('id','DESC');
        if(inTrashed($request))
        {
            $user=$user->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('string',$request) && !empty($request['string']))
        {
            $user=$user->where('title','like','%'.$request['string'].'%');
            $user=$user->orWhere('label','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'string='.$request['string']);
        }
        foreach ($with as $item){
            if ($item!=''){
                $user->with($item);
            }
        }
        $user=$user->paginate(10);
        $user->withPath($string);
        return $user;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
//    public function skills(){
//        return $this->belongsToMany(Skill::class);
//    }

    public function image(){
        return $this->morphOne(File::class,'fileable')->where('type','=','image');
    }
    public function gallery(){
        return $this->morphOne(File::class,'fileable')->where('type','=','gallery');
    }
}
