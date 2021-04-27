<?php

namespace App\Http\Resources\v1;

use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Resources\Json\JsonResource;
class QuestionResource extends JsonResource
{


    public $withAnswers;


    /**
     * @OA\Property(
     *     title="question",
     *     description="Data wrapper"
     * )
     * @var \App\Models\Question
     */
    private $question;

    /**
     * @OA\Property(
     *     title="status",
     *     description="Data status"
     * )
     *
     * @var boolean
     */
    private $status=true;

    /**
     * Create a new resource instance.
     *
     * @param  mixed $resource
     * @param bool $withAnswers
     */
    public function __construct($resource,$withAnswers=false)
    {
        $this->resource = $resource;
        $this->withAnswers = $withAnswers;
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
            'content'=>$this->content,
            'best_answer_id'=>$this->best_answer_id,
            'answerCount'=>$this->answerCount,
            'likeCount'=>$this->likeCount,
            'created'=>Verta::instance($this->created_at)->format('Y/m/d'),
            'past_tense'=>Verta::instance($this->created_at)->formatDifference(),
            'user'=>new UserSimpleResource($this->user),
            'best_answer'=>new AnswerResource($this->best_answer),
//            'skills'=>new SkillCollection($this->skills),
            'images'=>new FileCollection($this->images),
        ];
        if ($this->withAnswers){
            $data=array_merge($data,[
                'answers'=>new AnswerCollection($this->answers()->whereStatus('1')->oldest()->get())
            ]);
        }
        return $data;
    }
}
