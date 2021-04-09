<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserSimpleResource extends JsonResource
{
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
        ];
    }
}
