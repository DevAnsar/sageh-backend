<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
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

            $question = Question::find($question_id);

            $user=\App\Models\User::find(1);
            if ($question) {
                return response()->json([
                    'status' => true,
                    'question' => new QuestionResource($question, $user,true)
                ]);
            } else {
                return $this->customResponse(false, 'سوال یافت نشد');
            }


        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * @param $question_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendAnswers($question_id, Request $request)
    {
        try {

            if (!$request->has('content') || trim($request->input('content')) == '' || strlen($request->input('content')) < 5) {
                return $this->customResponse(false, 'موارد الزامی را وارد کنید', [], array(
                    'content' => 'پاسخی که میدهید باید از 5 کاراکتر بیشتر باشد'
                ));
            }

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
