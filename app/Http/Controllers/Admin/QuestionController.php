<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Question;
use App\Models\Search\QuestionSearch;
use Illuminate\Http\Request;

class QuestionController extends MainController
{
    protected $model = Question::class;
    protected $title = 'سوالات';
    protected $route_params = 'questions';
    public function route_params($data){
//        foreach ($data as $d){
//            $this->route_params=$this->route_params . 'questions/'.$d.'/answers';
//        }
        return $this->route_params;
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
//         $questions = Question::latest()->paginate(20);
//        $questions = Question::getData($request->all());
            $questions_search = new QuestionSearch(null ,10);
            $questions = $questions_search->getSearch($request, ['images']);
            $trash_question_count = Question::onlyTrashed()->count();

            $categories=Category::all();
            return view('admin.data.questions.index', compact('questions', 'request', 'trash_question_count','categories'));

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
        $categories=Category::all();
        return view('admin.data.questions.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
//        $skills=Skill::whereStatus(true)->latest()->get();
        $categories=Category::all();
        return view('admin.data.questions.edit', compact('question','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Question $question
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Question $question)
    {

        $this->validate($request, [
            'content' => 'required|min:3',
            'category_id' => 'required',
        ]);

        try {

            $question->update([
                'content' => $request->input('content'),
                'category_id' => $request->input('category_id'),
            ]);
//            $question->skills()->sync($request->input('skills'));

            return redirect(route('admin.questions.index'));
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question $question
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
//    public function destroy(Question $question)
//    {
//        foreach ($question->images() as $image){
//            deleteImage($image->url);
//            $image->delete();
//        }
//        $question->delete();
//
//        return back();
//    }
}
