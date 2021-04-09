<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


/**
 * @OA\Schema(
 *     title="UserResource",
 *     description="User Resource",
 *     @OA\Xml(
 *         name="UserResource"
 *     )
 * )
 */
class UserResource extends JsonResource
{
    protected  $thisHasMyAccount;
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource,$thisHasMyAccount=false)
    {
        $this->resource = $resource;
        $this->thisHasMyAccount=$thisHasMyAccount;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'=>$this->name,
            'family'=>$this->family,
            'brand'=>$this->brand,
            'username'=>$this->username,
            'avatar'=>$this->avatar?Storage::url($this->avatar['url']):null,
            'banner'=>$this->banner?Storage::url($this->banner['url']):null,
            'mobile'=>$this->mobile,
            'city'=>$this->city_id,
            'lat'=>$this->lat,
            'lng'=>$this->lng,
            'productsCount'=>$this->products()->count(),
            'followersCount'=>0,
            'hasMyFollowing'=>false,
            'thisHasMyAccount'=>$this->thisHasMyAccount,
        ];
    }
}
