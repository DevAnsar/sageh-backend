<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class SkillCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'label' => $item->label,
                'slug' => $item->slug,
                'icon' => $item->icon?Storage::url($item->icon['url']):null,
                'image' => $item->image?Storage::url($item->image['url']):null,
//                'users' => $item->users
            ];
        });
    }
}
