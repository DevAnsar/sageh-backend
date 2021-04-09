<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

//        Skill::factory(20)->create();

        Skill::factory(20)->create()->each(function ($skill){
            $skill->icon()->create([
                'name'=>'skill.png',
                'url'=>'skills/skill.png',
                'type'=>'icon',
            ]);
            $skill->image()->create([
                'name'=>'skills.png',
                'url'=>'skills/skills.png',
                'type'=>'image',
            ]);
//            $u->articles()->saveMany(factory(\App\Article::class,2)->make());
        });
    }
}
