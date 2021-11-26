<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CategoryController extends MainController
{
    protected $model = Category::class;
    protected $title = 'دسته بندی ها';
    protected $route_params = 'categories';

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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $categories = Category::getData($request->all(),['icon']);
        $trash_category_count = Category::onlyTrashed()->count();
//        $allSkills=Skill::oldest()->select(['id','title'])->with(['icon'])->get();
        return view('admin.manager.categories.index', compact('categories', 'request', 'trash_category_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manager.categories.create');
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
            $category = Category::create($inputs);

            if ($request->hasFile('icon')) {
                $icon_url=uploadImage($request->file('icon'), "categories/$category->slug/icon", 'icon');
                $category->icon()->create(['url' =>$icon_url, 'type' => 'icon']);
            }
            if ($request->hasFile('image')) {
                $image=uploadImage($request, "categories/$category->slug/image", 'image');
                $category->image()->create(['url' => $image['url'], 'type' => 'image']);
            }
            return redirect(route('admin.categories.index'));

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.manager.categories.edit', compact('category'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Category $category)
    {
//        return deleteImage($category->icon->url);
//        return $category->icon->url;
        $this->validate($request, [
            'title' => 'required|min:1',
            'label' => 'required|min:1',
        ]);

        try {
            $inputs = $request->all();
            $category->update($inputs);

            if ($request->file('icon')) {
                $res = uploadImage($request->file('icon'), "/categories/$category->slug/icon", 'icon');
                if ($res) {
                    if ($category->icon) {
                        deleteImage($category->icon['url']);
                        $category->icon()->update(['url' => $res, 'name' => 'icon']);
                    } else {
                        $category->icon()->create(['url' => $res, 'name' => 'icon', 'type' => 'icon']);
                    }
                }
            }

            if ($request->file('image')) {
                $res = uploadImage($request->file('image'), "/categories/$category->slug/image", 'image');
                if ($res) {
                    if ($category->image) {
                        deleteImage($category->image['url']);
                        $category->image()->update(['url' => $res, 'name' => 'image']);
                    } else {
                        $category->image()->create(['url' => $res, 'name' => 'image', 'type' => 'image']);
                    }
                }
            }


            return redirect(route('admin.categories.index'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

//    public function store_skills($category_id,Request $request){
////        return $request->data;
//
//        try{
//            $skills_id=array_filter(explode(',',$request->data));
//            $category=Category::find($category_id);
//            if ($category){
//                $category->skills()->sync($skills_id);
//            }
//            return response()->json([
//                'status'=>true,
//                'message'=>'مهارت با موفق برای دسته بندی ثبت شد'
//            ]);
//        }catch (\Exception $exception){
//            return response()->json([
//                'status'=>false,
//                'message'=>$exception->getMessage()
//            ]);
//        }
//
//    }
}
