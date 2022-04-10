<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
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
        for ($i = 5; $i < 9; $i++) {
            $batch[] = [
                'role_id' => 2,
                'permission_id' => $i,
            ];
        }
        DB::table('role_permission')->insert($batch);
    }
}
