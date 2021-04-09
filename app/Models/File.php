<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     title="File",
 *     description="File model",
 *     @OA\Xml(
 *         name="File"
 *     )
 * )
 */
class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'type'
    ];

    /**
     * @OA\Property(
     *      title="name",
     *      description="file name",
     *      example="image.jpg"
     * )
     *
     * @var string
     */
    public $name;


    /**
     * @OA\Property(
     *      title="url",
     *      description="file url",
     *      example="http://biilche.ir/images/image.jpg"
     * )
     *
     * @var string
     */
    public $url;

    /**
     * @OA\Property(
     *      title="type",
     *      description="file type",
     *      example="icon,image,avatar,..."
     * )
     *
     * @var string
     */
    public $type;


    public function fileable()
    {
        return $this->morphTo();
    }
}
