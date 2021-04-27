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

            $paginate = 10;
            if ($request->has('paginate') && $request->input('paginate') != 0) {
                $paginate = $request->input('paginate');
            }
            $questions_obj = new QuestionSearch($paginate);
            $questions = $questions_obj->getSearchForClient($request, ['images', 'user','category']);
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendQuestions(Request $request)
    {
        try {
//            $this->validate($request,[
//                'content'=>'required|min:5',
//            ]);

            $user = auth()->user();

            $request_valid = true;
            $errors = [];
            if (!$request->has('content') || trim($request->input('content')) == '' || strlen($request->input('content')) < 5) {
                $request_valid = false;
                $errors = array_merge($errors, array(
                    'content' => 'محتوای پرسش نمیتواند کمتر از 5 کاراکتر باشد'
                ));

            }
            if (!$request->has('category_id') || trim($request->input('category_id')) == 0) {
                $request_valid = false;
                $errors = array_merge($errors, array(
                    'category_id' => 'دسته ی  سوال را باید مشخص کنید'
                ));
            }

            if (!$request_valid) {
                return $this->customResponse(false, 'موارد الزامی را وارد کنید', [], $errors);

            }

            $question = $user->questions()->create([
                'content' => $request->input('content'),
                'category_id' => $request->input('category_id', 0),
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


    /*
     * @param StoreQuestionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleToFavorite(Request $request)
    {
        try {

            $request_valid = true;
            $errors = [];
            if (!$request->has('question_id') || $request->input('question_id')== 0 || !is_numeric($request->input('question_id'))) {
                $request_valid = false;
                $errors = array_merge($errors, array(
                    'question_id' => 'آیدی پرسش الزامی است'
                ));
            }

            if (!$request_valid) {
                return $this->customResponse(false, 'موارد الزامی را وارد کنید', [], $errors);

            }
            $user = auth()->user();

//            $this->validate($request, [
//                'question_id' => 'required|int',
//            ]);

            $question_id = $request->input('question_id');
            $question = Question::find($question_id);

            if ($question) {
                $favorite = $user->favorite_questions()->where('question_id', $question_id)->first();
                if ($favorite) {
                    $user->favorite_questions()->detach($question);
                    return $this->customResponse(true, 'سوال از لیست علاقه مندی ها حذف شد');
                } else {
                    $user->favorite_questions()->attach($question);
                    return $this->customResponse(true, 'سوال به لیست ذخیره اضافه شد');
                }
            } else {
                return $this->customResponse(true, 'سوالی برای درخواست شما ثبت نشده است');
            }


        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    public function my_favorite_questions(){

        try{
            $user = auth()->user();
            $favorites = new QuestionCollection($user->favorite_questions);

            return response()->json([
                'status'=>true,
                'questions'=>$favorites
            ]);
        }catch (\Exception $exception){
            return $this->exceptionResponse($exception);
        }

    }
    public function my_question_edit($question_id=0,Request $request){

        try{
            $errors=[];
            $request_valid=true;

            $user = auth()->user();
            $question = Question::find($question_id);

            if (!$question){
                return $this->customResponse(false,'سوال یافت نشد');
            }

            if ($question->user_id != $user->id){
                return $this->customResponse(false,'اجازه ی دسترسی ندارید');

            }


            if (!$request->has('content') || trim($request->input('content'))=='' || strlen($request->input('content'))<5){

                $request_valid = false;
                $errors = array_merge($errors, array(
                    'content' => 'متن سوال باید از 5 کاراکتر بیشتر باشد'
                ));
            }


            if (!$request_valid) {
                return $this->customResponse(false, 'موارد الزامی را وارد کنید', [], $errors);

            }

            $question->update([
                'content'=>$request->input('content'),
                'category_id'=>$request->input('category_id',$question->category_id)
            ]);

            return response()->json([
                'status'=>true,
                'message'=>'سوال با موفقیت ویرایش شد'
            ]);
        }catch (\Exception $exception){
            return $this->exceptionResponse($exception);
        }

    }


    public function set_best_answer($question_id=0,Request $request){

        try{
            $errors=[];
            $request_valid=true;

            $user = auth()->user();
            $question = Question::find($question_id);

            if (!$question){
                return $this->customResponse(false,'سوال یافت نشد');
            }

            if ($question->user_id != $user->id){
                return $this->customResponse(false,'اجازه ی دسترسی ندارید');

            }


            if (!$request->has('answer_id')  || !is_numeric($request->input('answer_id'))){

                $request_valid = false;
                $errors = array_merge($errors, array(
                    'answer_id' => 'آیدی جواب مورد نظر برای ثبت به عنوان بهترین پاسخ الزامی میباشد'
                ));
            }


            if (!$request_valid) {
                return $this->customResponse(false, 'موارد الزامی را وارد کنید', [], $errors);

            }
            $answer_id=$request->input('answer_id');
            if (!in_array($answer_id,$question->answers()->pluck('id')->toArray())){
                return $this->customResponse(false,'پاسخ برای سوال مورد تایید نیست');
            }

            $question->update([
                'best_answer_id'=>$answer_id,
            ]);

            return response()->json([
                'status'=>true,
                'message'=>'بهترین جواب برای سوال ثبت شد'
            ]);
        }catch (\Exception $exception){
            return $this->exceptionResponse($exception);
        }

    }


    public function my_question_destroy($question_id=0){

        try{

            $user = auth()->user();
            $question = Question::find($question_id);

            if (!$question){
                return $this->customResponse(false,'سوال یافت نشد');
            }

            if ($question->user_id != $user->id){
                return $this->customResponse(false,'اجازه ی دسترسی ندارید');

            }
            $question->delete();

            return response()->json([
                'status'=>true,
                'message'=>'سوال با موفقیت حذف شد'
            ]);
        }catch (\Exception $exception){
            return $this->exceptionResponse($exception);
        }

    }
}
