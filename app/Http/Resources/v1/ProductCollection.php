<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item){
                return [
                    'title'=>$item->title,
                    'image'=>$item->image?Storage::url($item->image['url']):null,
                    'description'=>$item->description,
                    'gallery'=>$item->gallery,
                    'category'=>new CategoryResource($item->category),
                    'user'=>new UserSimpleResource($item->user),
//                    'skills'=>new SkillCollection($item->skills)
                ];
            });
    }
}
