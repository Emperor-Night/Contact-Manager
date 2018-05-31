<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{

    public function run()
    {
        $groups = ["Family", "Friends", "Clients"];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Group::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($x = 1; $x <= 3; $x++) {

            for ($i = 0; $i < 3; $i++) {
                \App\Group::create([
                    "name"    => $groups[$i],
                    "user_id" => $x
                ]);
            }

        }

    }


}
