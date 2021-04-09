<?php

namespace App\Http\Resources\v1;

use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AnswerCollection extends ResourceCollection
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
            return[
                'id'=>$item->id,
                'content'=>$item->content,
                'likeCount'=>$item->likeCount,
                'created'=>Verta::instance($item->created_at)->format('Y/m/d'),
                'past_tense'=>Verta::instance($item->created_at)->formatDifference(),
                'user'=>new UserSimpleResource($item->user),
                'images'=>new FileCollection($item->images),
            ];
        });
    }
}
