<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @OA\Schema(
 *     title="Skill",
 *     description="Skill model",
 *     @OA\Xml(
 *         name="Skill"
 *     )
 * )
 */
class Skill extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'label',
        'slug',
        'status',
    ];

    /**
     * @OA\Property(
     *     title="id",
     *     description="skill id",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *     title="user_id",
     *     description="question user id",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $user_id;

    /**
     * @OA\Property(
     *     title="title",
     *     description="skill title",
     *     format="string",
     *     example="مهندسی کشاورزی"
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @OA\Property(
     *      title="label",
     *      description="skill label",
     *      example="agri eng"
     * )
     *
     * @var string
     */
    private $label;

    /**
     * @OA\Property(
     *      title="slug",
     *      description="skill slug",
     *      example="agri-ang"
     * )
     *
     * @var string
     */
    private $slug;

    /**
     * @OA\Property(
     *      title="icon",
     *      description="skill icon url",
     *      example="http://biilche.ir/images/icon.png"
     * )
     *
     * @var string
     */
    private $icon;

    /**
     * @OA\Property(
     *      title="image",
     *      description="skill image",
     *      example="http://biilche.ir/images/image.png"
     * )
     *
     * @var string
     */
    private $image;

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

    public static function getData($request)
    {
        $string='?';
        $skill=self::orderBy('id','DESC');
        if(inTrashed($request))
        {
            $skill=$skill->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('string',$request) && !empty($request['string']))
        {
            $skill=$skill->where('title','like','%'.$request['string'].'%');
            $skill=$skill->orWhere('label','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'string='.$request['string']);
        }
        $skill=$skill->paginate(10);
        $skill->withPath($string);
        return $skill;
    }
    public function icon()
    {
        return $this->morphOne(File::class, 'fileable')->where('type','=','icon');
    }
    public function image()
    {
        return $this->morphOne(File::class, 'fileable')->where('type','=','image');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User','skill_users','skill_id','user_id');
    }

    public function questions()
    {
        return $this->belongsToMany('App\Models\Question','question_skills','skill_id','question_id');
    }
}
