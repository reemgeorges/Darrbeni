<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Code;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::create([
            'name'=>'Admin',
            'mobile_phone'=>'0991568845',
            'role'=>'admin'
        ]);

        Code::create([
            'user_id'=>$user->id,
            'login_code'=>  Str::random(6, '1234567890'),
        ]);
    }
}
