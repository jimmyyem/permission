<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $batch = [];

        //普通管理员
        for ($i = 1; $i < 5; $i++) {
            $batch[] = [
                'role_id' => 2,
                'user_id' => $i,
            ];
        }

        //普通用户
        for ($i = 5; $i < 8; $i++) {
            $batch[] = [
                'role_id' => 3,
                'user_id' => $i,
            ];
        }

        DB::table('user_role')->insert($batch);
    }
}
