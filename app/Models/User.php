<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable ,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'family',
        'brand',
        'username',
        'mobile',
        'national_code',
        'city_id',
        'address',
        'lat',
        'lng',
        'email',
        'password',
        'login_code',
        'status',
        'mobile_status',
        'business'
    ];

//    public static function getData($request,$with=[])
//    {
//        $string='?';
//        $user=self::orderBy('created_at','DESC');
//        if(inTrashed($request))
//        {
//            $user=$user->onlyTrashed();
//            $string=create_paginate_url($string,'trashed=true');
//        }
//        if(array_key_exists('string',$request) && !empty($request['string']))
//        {
//            $user=$user->where('name','like','%'.$request['string'].'%');
//            $user=$user->orWhere('family','like','%'.$request['string'].'%');
//            $string=create_paginate_url($string,'string='.$request['string']);
//        }
//        foreach ($with as $item){
//            if ($item!=''){
//                $user->with($item);
//            }
//        }
//        $user=$user->paginate(10);
//        $user->withPath($string);
//        return $user;
//    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function avatar()
    {
        return $this->morphOne('App\Models\File', 'fileable')
            ->where('type','=','avatar');
    }
    public function banner()
    {
        return $this->morphOne('App\Models\File', 'fileable')
            ->where('type','=','banner');
    }
    public function national_cart_image()
    {
        return $this->morphOne('App\Models\File', 'fileable')
            ->where('type','=','national_cart_image');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category','category_user','user_id','category_id');
    }
//    public function skills()
//    {
//        return $this->belongsToMany('App\Models\Skill','skill_users','user_id','skill_id');
//    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question','user_id','id');
    }
    public function answers()
    {
        return $this->hasMany('App\Models\Answer','user_id','id');
    }

    public function favorite_questions(){
        return $this->belongsToMany(Question::class,'favorite_questions','user_id','question_id');
    }
    public function favorite_products(){
        return $this->belongsToMany(Product::class,'favorite_products','user_id','product_id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
