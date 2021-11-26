<?php

namespace App\Http\Controllers\Admin;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends MainController
{
    protected  $model=Skill::class;
    protected  $title='مهارت شغلی';
    protected $route_params='skills';
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $skills = Skill::getData($request->all());
        $trash_skill_count=Skill::onlyTrashed()->count();
        return view('admin.manager.skills.index', compact('skills','request','trash_skill_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manager.skills.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:1',
            'label' => 'required|min:1',
        ]);

        try {
            $inputs = $request->all();
            $skill = Skill::create($inputs);

            if ($request->hasFile('icon')) {
                $icon=uploadImage($request, "categories/$skill->slug/icon", 'icon');
                $skill->icon()->create(['url' =>$icon['url'], 'type' => 'icon']);
            }
            if ($request->hasFile('image')) {
                $image=uploadImage($request, "categories/$skill->slug/image", 'image');
                $skill->image()->create(['url' => $image['url'], 'type' => 'image']);
            }

            return redirect(route('admin.skills.index'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Skill $skill
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Skill $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        return view('admin.manager.skills.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Skill $skill
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Skill $skill)
    {
//        return deleteImage($skill->icon->url);
//        return $skill->icon->url;
        $this->validate($request, [
            'title' => 'required|min:1',
            'label' => 'required|min:1',
        ]);

        try {
            $inputs = $request->all();
            $skill->update($inputs);

            if ($request->file('icon')) {
                $res = uploadImage($request, "skills/$skill->slug/icon",'icon');
                if ($res['status']) {
                    if ($skill->icon) {
                        deleteImage($skill->icon['url']);
                        $skill->icon()->update(['url' => $res['url'],'name'=>$res['name']]);
                    } else {
                        $skill->icon()->create(['url' => $res['url'],'name'=>$res['name'], 'type' => 'icon']);
                    }
                }
            }

            if ($request->file('image')) {
                $res = uploadImage($request, "/skills/$skill->slug/image",'image');
                if ($res['status']) {
                    if ($skill->image) {
                        deleteImage($skill->image['url']);
                        $skill->image()->update(['url' => $res['url'],'name'=>$res['name']]);
                    } else {
                        $skill->image()->create(['url' => $res['url'],'name'=>$res['name'], 'type' => 'image']);
                    }
                }
            }


            return redirect(route('admin.skills.index'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//        try{
////            return $id;
//            $query_string=property_exists($this,'query_string') ? '&'.$this->query_string : '';
//            $model_name=$this->model;
//            $row=$model_name::withTrashed()->findOrFail($id);
//            if($row->deleted_at==null){
//                $message="$this->title  انتخاب شده به سطل زباله انتقال یافت";
//                $row->delete();
//            }
//            else{
//                $message="$this->title  انتخاب شده حذف شد";
//
//                $row->icon?deleteImage($row->icon->url):null;
//                $row->image?deleteImage($row->image->url):null;
//
//                $row->forceDelete();
//            }
//            return redirect('admin/'.$this->route_params.'?trashed=true'.$query_string)->with('message',$message);
//
//        }catch (\Exception $e){
//            return back()->withErrors($e->getMessage());
//        }
//    }
}
