<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreQuestionRequest;
use App\Http\Resources\v1\QuestionCollection;
use App\Http\Resources\v1\QuestionResource;
use App\Models\Question;
use App\Models\Search\QuestionSearch;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuestions(Request $request)
    {
        try {

            $paginate=10;
            if ($request->has('paginate') && $request->input('paginate')!=0){
                $paginate=$request->input('paginate');
            }
            $questions_obj=new QuestionSearch($paginate);
            $questions=$questions_obj->getSearchForClient($request,['images','user']);
//            $questions = Question::where('status', '=', '1')
//                ->with('user')
//                ->latest()
//                ->paginate(5);

            return response()->json([
                'status' => true,
                'questions' => new QuestionCollection($questions)
            ]);


        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }


    /**
     * @OA\Post(
     *      path="/sendQuestions",
     *      operationId="storeQuestion",
     *      tags={"Questions"},
     *      summary="Store New Question",
     *      description="Store New Question",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreQuestionRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @param StoreQuestionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendQuestions(StoreQuestionRequest $request)
    {
        try {
            $user = auth()->user();

//            $this->validate($request,[
//                'content'=>'required|min:5',
//            ]);

            $question = $user->questions()->create([
                'content' => $request->input('content'),
                'status' => '1',
            ]);

            return response()->json([
                'status' => true,
                'question' => new QuestionResource($question),
            ]);


        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }


    /**
     * @OA\Post(
     *      path="/questions/toggleToFavorite",
     *      operationId="toggleToFavorite",
     *      tags={"Questions"},
     *      summary="Add/Delete from to user favorite question list",
     *      description="",
     *      @OA\RequestBody(
     *          required=true,
     *    title="question_id"
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @param StoreQuestionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleToFavorite(Request $request)
    {
        try {
            $user = auth()->user();

            $this->validate($request, [
                'question_id' => 'required|int',
            ]);

            $question_id = $request->input('question_id');
            $question = Question::find($question_id);

            if ($question) {
                $favorite = $user->favorite_questions()->where('question_id', $question_id)->first();
                if ($favorite) {
                    $user->favorite_questions()->detach($question);
                    return response()->json([
                        'status' => true,
                        'message' => 'سوال از لیست علاقه مندی ها حذف شد',
                    ]);
            } else {
                    $user->favorite_questions()->attach($question);
                    return response()->json([
                        'status' => true,
                        'message' => 'سوال به لیست ذخیره اضافه شد',
                    ]);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'سوالی برای درخواست شما ثبت نشده است',
                ]);
            }




        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
}
