<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class speciseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Specialization::create([
            'specialization_name'=>'الهندسة المعلوماتية',
            'image'=>'public/images/ZngdFkANvbgFVMcSFxtDkjZbJeQICzZMPP0m6WuV.jpg',
            'collage_id'=>'1'

        ]);
        Specialization::create([
            'specialization_name'=>'الهندسة المعمارية',
            'image'=>'public/images/ZngdFkANvbgFVMcSFxtDkjZbJeQICzZMPP0m6WuV.jpg',
            'collage_id'=>'1'

        ]);
        Specialization::create([
            'specialization_name'=>'الطب البشري',
            'image'=>'public/images/ZngdFkANvbgFVMcSFxtDkjZbJeQICzZMPP0m6WuV.jpg',
            'collage_id'=>'2'


        ]);
        Specialization::create([
            'specialization_name'=>'طب الاسنان',
            'image'=>'public/images/ZngdFkANvbgFVMcSFxtDkjZbJeQICzZMPP0m6WuV.jpg',
            'collage_id'=>'2'


        ]);
        Specialization::create([
            'specialization_name'=>'التمريض',
            'image'=>'public/images/ZngdFkANvbgFVMcSFxtDkjZbJeQICzZMPP0m6WuV.jpg',
            'collage_id'=>'2'


        ]);
        
    }
}
