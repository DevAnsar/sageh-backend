<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,Sluggable,SoftDeletes;

    protected $fillable=[
        'title',
        'label',
        'slug',
        'order_number',
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
                'source' => 'label'
            ]
        ];
    }

    public static function getData($request,$with=[])
    {
        $string='?';
        $category=self::orderBy('id','DESC');
        if(inTrashed($request))
        {
            $category=$category->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('string',$request) && !empty($request['string']))
        {
            $category=$category->where('title','like','%'.$request['string'].'%');
            $category=$category->orWhere('label','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'string='.$request['string']);
        }
        foreach ($with as $item){
            if ($item!=''){
            $category->with($item);
            }
        }
        $category=$category->paginate(10);
        $category->withPath($string);
        return $category;
    }

//    public function skills(){
//        return $this->belongsToMany(Skill::class);
//    }
    public function image(){
        return $this->morphOne(File::class,'fileable')->where('type','=','image');
    }
    public function icon(){
        return $this->morphOne(File::class,'fileable')->where('type','=','icon');
    }

    public function products(){
        return $this->hasMany(Product::class,'id','category_id');
    }

    public function questions(){
        return $this->hasMany(Question::class,'category_id','id');
    }
}
