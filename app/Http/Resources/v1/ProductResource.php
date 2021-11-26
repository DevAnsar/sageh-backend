<?php

namespace App\Http\Resources\v1;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param  mixed $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data=[
            'id'=>$this->id,
            'title'=>$this->title,
            'image'=>$this->image?$this->image:null,
            'description'=>$this->description,
            'gallery'=>$this->gallery,
            'category'=>new CategoryResource($this->category),
            'user'=>new UserSimpleResource($this->user),
//            'skills'=>new SkillCollection($this->skills)
        ];
        return $data;
    }
}
