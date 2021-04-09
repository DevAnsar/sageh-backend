<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function dashboard(){

        $lastUsers=User::latest()->take(3)->get();
        $usersCount=User::all()->count();
        $categoriesCount=Category::all()->count();
        $skillsCount=Skill::all()->count();
        $questionsCount=Question::all()->count();
        $productsCount=Question::all()->count();

        return view('admin.dashboard',compact(
            'lastUsers',
            'usersCount',
            'usersCount',
            'categoriesCount',
            'skillsCount',
            'questionsCount',
            'productsCount'
        ));
    }

    public function messages(){
        $user=auth()->user();
        return view('admin.data.chats.index',compact('user'));
    }
}
