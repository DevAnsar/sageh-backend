<?php

namespace App\Http\Controllers\Admin;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Search\AnswerSearch;
use Illuminate\Http\Request;

class AnswerController extends MainController
{
    protected $model = Answer::class;
    protected $title = 'پاسخ ها';
    public $route_params = '';
    public function route_params($data){
        foreach ($data as $d){
            $this->route_params=$this->route_params . 'questions/'.$d.'/answers';
        }
        return $this->route_params;
    }
    /**
     * Display a listing of the resource.
     *
     * @param Question $question
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Question $question,Request $request)
    {

        try {

//         $questions = Question::latest()->paginate(20);
//        $questions = Question::getData($request->all());
            $answers_search = new AnswerSearch($question,10);
            $answers = $answers_search->getSearch($request, ['images']);

            if ($answers->count() != $question->answerCount){
                $question->update([
                    'answerCount'=>$answers->count()
                ]);
            }

            $trash_answer_count = Answer::onlyTrashed()->count();

            return view('admin.data.answers.index',compact('question','answers','request','trash_answer_count'));


        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @param  \App\Models\Answer $answer
     * @return Answer
     */
    public function show(Question $question,Answer $answer)
    {
        return $answer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @param  \App\Models\Answer $answer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Question $question,Answer $answer)
    {
        return view('admin.data.answers.edit', compact('question','answer'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Question $question
     * @param  \App\Models\Answer $answer
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,Question $question, Answer $answer)
    {
        $this->validate($request, [
            'content' => 'required',
        ]);

        try {
            $inputs = $request->all();
            $answer->update($inputs);

//            if ($request->file('icon')) {
//                $res = uploadImage($request, "categories/$category->slug/icon", 'icon');
//                if ($res['status']) {
//                    if ($category->icon) {
//                        deleteImage($category->icon['url']);
//                        $category->icon()->update(['url' => $res['url'], 'name' => $res['name']]);
//                    } else {
//                        $category->icon()->create(['url' => $res['url'], 'name' => $res['name'], 'type' => 'icon']);
//                    }
//                }
//            }
//
//            if ($request->file('image')) {
//                $res = uploadImage($request, "/categories/$category->slug/image", 'image');
//                if ($res['status']) {
//                    if ($category->image) {
//                        deleteImage($category->image['url']);
//                        $category->image()->update(['url' => $res['url'], 'name' => $res['name']]);
//                    } else {
//                        $category->image()->create(['url' => $res['url'], 'name' => $res['name'], 'type' => 'image']);
//                    }
//                }
//            }


            return redirect(route('admin.answers.index',['question'=>$question]));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
