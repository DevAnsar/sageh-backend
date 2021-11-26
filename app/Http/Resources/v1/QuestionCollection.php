<?php

namespace App\Http\Resources\v1;

use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     title="QuestionCollection",
 *     description="Question Collection",
 *     @OA\Xml(
 *         name="QuestionCollection"
 *     )
 * )
 */
class QuestionCollection extends ResourceCollection
{

    public $logged_user;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param $logged_user
     */
    public function __construct($resource, $logged_user)
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);
        $this->logged_user=$logged_user;
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item){
            $questions=[
                'id'=>$item->id,
                'content'=>$item->content,
                'best_answer_id'=>$item->best_answer_id,
                'answerCount'=>$item->answerCount,
                'likeCount'=>$item->likeCount,
                'created'=>Verta::instance($item->created_at)->format('Y/m/d'),
                'past_tense'=>Verta::instance($item->created_at)->formatDifference(),
                'user'=>new UserSimpleResource($item->user),
                'best_answer'=>$item->best_answer?new AnswerResource($item->best_answer):null,
//                'skills'=>new SkillCollection($item->skills),
                'images'=>new FileCollection($item->images),
                'category'=>new CategoryResource($item->category),
                'hasBookmark'=>questionHasBookmark($this->logged_user,$item)
            ];
            return $questions;
        });
    }
}
