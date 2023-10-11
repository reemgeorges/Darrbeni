<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Collage;

class CollageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Collage::create([
            'collage_name'=>'الكليات الهندسية'
        ]);
        Collage::create([
            'collage_name'=>'الكليات الطبية'
        ]);
    }
}
