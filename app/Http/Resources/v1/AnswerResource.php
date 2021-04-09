<?php

namespace App\Http\Resources\v1;

use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'id'=>$this->id,
            'content'=>$this->content,
            'likeCount'=>$this->likeCount,
            'created'=>Verta::instance($this->created_at)->format('Y/m/d'),
            'past_tense'=>Verta::instance($this->created_at)->formatDifference(),
            'user'=>new UserResource($this->user),
            'images'=>new FileCollection($this->images),
        ];
    }
}
