<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Search\UserSearch;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends MainController
{
    protected $model = User::class;
    protected $title = 'کاربر';
    protected $route_params = 'users';
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

//        $users = User::getData($request->all(),['avatar']);
        $users_search=new UserSearch(0,1);
        $users=$users_search->getSearch($request,['avatar'],10);
        $trash_user_count = User::onlyTrashed()->count();
//        $allSkills=Skill::oldest()->select(['id','title'])->with(['icon'])->get();
        $allCategories=Category::oldest()->select(['id','title'])->with(['icon'])->get();
        return view('admin.data.users.index', compact('users', 'request', 'trash_user_count','allCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.data.users.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return User
     */
    public function show(User $user)
    {

        return $user;
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
            'name' => 'required|min:1',
            'family' => 'required|min:1',
            'username' => 'nullable',
            'national_code' => 'nullable',
            'mobile' => 'required',
            'password' => 'required',
        ]);

        try {

            ////////////// initial user data
            $password=$request->input('password');
            if ($password==null || $password==''){$password='biilche';}
            $username=$request->input('username');
            if (!$username){
                $username='u_'.generateRandomNumber(4);
            }
            ///////////////

            $inputs = $request->all();
            $user = User::create(array_merge($inputs,[
                'password'=>Hash::make($password),
                'username'=>$username
            ]));

            if ($request->hasFile('avatar')) {
                $avatar=uploadImage($request, "users/$user->id/avatar", 'avatar');
                $user->avatar()->create(['url' =>$avatar['url'], 'type' => 'avatar']);
            }
            if ($request->hasFile('national_cart_image')) {
                $image=uploadImage($request, "users/$user->id/national_cart", 'national_cart_image');
                $user->national_cart_image()->create(['url' => $image['url'], 'type' => 'national_cart_image']);
            }
            return redirect(route('admin.users.index'));

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        return view('admin.data.users.edit', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,User $user)
    {
        $this->validate($request, [
            'name' => 'required|min:1',
            'family' => 'required|min:1',
            'username' => 'nullable',
            'national_code' => 'nullable',
            'mobile' => 'required',
            'password' => 'nullable',
        ]);

        try {

            $data=[];
            ////////////// initial user data
            $password=$request->input('password');
            if ($password!=null || $password!=''){
                $data=array_merge($data,['password'=>Hash::make($password)]);
            }else{
                unset($request['password']);
            }
            ///////////////

            $inputs = $request->all();
            $user->update(array_merge($inputs,$data));

            if ($request->file('avatar')) {
                $res = uploadImage($request, "users/$user->id/avatar", 'avatar');
                if ($res['status']) {
                    if ($user->avatar) {
                        deleteImage($user->avatar['url']);
                        $user->avatar()->update(['url' => $res['url'], 'name' => $res['name'], 'type' => 'avatar']);
                        return $user->avatar;
                    } else {
                        $user->avatar()->create(['url' => $res['url'], 'name' => $res['name'], 'type' => 'avatar']);
                    }
                }
            }

            if ($request->file('national_cart_image')) {
                $res = uploadImage($request, "/users/$user->id/national_cart", 'national_cart_image');
                if ($res['status']) {
                    if ($user->national_cart_image) {
                        deleteImage($user->national_cart_image['url']);
                        $user->national_cart_image()->update(['url' => $res['url'], 'name' => $res['name']]);
                    } else {
                        $user->national_cart_image()->create(['url' => $res['url'], 'name' => $res['name'], 'type' => 'national_cart_image']);
                    }
                }
            }
            return redirect(route('admin.users.index'));

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

    }

//    public function store_skills($user_id,Request $request){
////        return $request->data;
//
//        try{
//            $skills_id=array_filter(explode(',',$request->data));
//            $user=User::find($user_id);
//            if ($user){
//                $user->skills()->sync($skills_id);
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
    public function store_categories($user_id,Request $request){
//        return $request->data;

        try{
            $categories_id=array_filter(explode(',',$request->data));
            $user=User::find($user_id);
            if ($user){
                $user->categories()->sync($categories_id);
            }
            return response()->json([
                'status'=>true,
                'message'=>'دسته با موفق برای کاربر ثبت شد'
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status'=>false,
                'message'=>$exception->getMessage()
            ]);
        }

    }
}
