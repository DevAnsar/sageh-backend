<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreAnswerRequest;
use App\Http\Resources\v1\AnswerResource;
use App\Http\Resources\v1\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * @param $question_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAnswers($question_id)
    {
        try {

            $question=Question::find($question_id);

            if ($question){
                return response()->json([
                    'status' => true,
                    'question' => new QuestionResource($question,true)
                ]);
            }else{
                return $this->customResponse(false,'سوال یافت نشد');
            }


        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * @OA\Post(
     *      path="/questions/{question_id}/sendAnswers",
     *      operationId="storeAnswers",
     *      tags={"Questions"},
     *      summary="Store New Answer for Question",
     *      description="",
     *
     *
     *     @OA\Parameter(
     *          name="question_id",
     *          description="Question id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreAnswerRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/QuestionResource")
     *       ),
     *     )
     * @param $question_id
     * @param StoreAnswerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendAnswers($question_id, StoreAnswerRequest $request)
    {
        try {

            $user = auth()->user();
            $question = Question::findOrFail($question_id);
            $answer = $question->answers()->create([
                'content' => $request->input('content'),
                'user_id' => $user->id,
                'status' => '1',
            ]);

            $question->update([
                'answerCount' => $question->answers()->whereStatus('1')->count()
            ]);
            return response()->json([
                'status' => true,
                'answer' => new AnswerResource($answer)
            ]);

        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
}
