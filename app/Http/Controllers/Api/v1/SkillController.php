<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\SkillCollection;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * @OA\Get(
     *
     *     path="/getSkills",
     *     tags={"Skills"},
     *     summary="",
     *     description="Show all job skills",
     *     @OA\Response(response="200", description="Skill Collection")
     * )
     */
    public function getSkills(){
       try{
           $skills=Skill::where('status','=',true)
//               ->with('users')
               ->latest()->get();

           return response()->json([
               'status'=>true,
               'skills'=>new SkillCollection($skills)
           ]);


       }catch (\Exception $exception){
           return $this->exceptionResponse($exception);
       }
    }

}
