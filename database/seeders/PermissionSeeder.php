<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
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
        foreach (['user', 'post'] as $first) {
            foreach (['view', 'create', 'update', 'delete'] as $second) {
                $item = $second.'.'.$first;
                $batch[] = [
                    'name' => $item,
                    'slug' => $item,
                ];
            }
        }

        DB::table('permissions')->insert($batch);
    }
}
