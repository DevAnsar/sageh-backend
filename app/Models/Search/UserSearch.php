<?php

namespace App\Models\Search;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class UserSearch
{
    use HasFactory;

    public $category_id;
    public $users = [];
    public $string = '?';
    protected $paginate;

    public function __construct($category_id=0, $paginate = 10)
    {
        $this->category_id = $category_id;
        $this->paginate = $paginate;
    }

    public function getSearch(Request $request, $with = [])
    {

//        $skills=explode(',',$skills);
//        $skills=array_filter($skills);

         $users = User::query()->orderBy('created_at','DESC');

        if(inTrashed($request))
        {

            $users=$users->onlyTrashed();
            $this->string=create_paginate_url($this->string,'trashed=true');
        }
        if(isset($request['string']) && !empty($request['string']))
        {
            $searchValues = preg_split('/\s+/', $request['string']);
            $users->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->where('name', 'like', '%' . $value . '%')
                        ->orWhere('family', 'like', '%' . $value . '%')
                        ->orWhere('username', 'like', '%' . $value . '%');
                }
            });
//            $users=$users->where('name','like','%'.$request['string'].'%');
//            $users=$users->orWhere('family','like','%'.$request['string'].'%');
            $this->string=create_paginate_url($this->string,'string='.$request['string']);
        }

        foreach ($with as $item) {
            if ($item != '') {
                $users->with($item);
            }
        }

        if ($this->category_id != 0) {
            $users->whereHas('categories', function ($q) {
                $q->where('id', $this->category_id);
            });
        }
//        if (sizeof($skills)>0){
//            $users->whereHas('skills',function ($q) use ($skills){
//                $q->whereIn('id',$skills);
//            });
//        }

//        if ($string != null || $string != '') {
//            $searchValues = preg_split('/\s+/', $string);
//            $users->where(function ($q) use ($searchValues) {
//                foreach ($searchValues as $value) {
//                    $q->where('name', 'like', '%' . $value . '%')
//                        ->orWhere('family', 'like', '%' . $value . '%')
//                        ->orWhere('username', 'like', '%' . $value . '%');
//                }
//            });
//        }



        $users=$users->paginate($this->paginate);
        $users=$users->withPath($this->string);
        $this->users = $users;

        return $users;
    }

    public function getResults()
    {

        $users=$this->users->paginate($this->paginate);

        return $users;
    }
}
