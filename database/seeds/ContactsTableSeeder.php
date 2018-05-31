<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ContactsTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Contact::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();

        foreach (range(1, 50) as $item) {

            $user_id = rand(1, 3);

            if ($user_id == 1) {
                $arr = [1, 2, 3];
                $group_id = $arr[array_rand($arr)];
            } else if ($user_id == 2) {
                $arr = [4, 5, 6];
                $group_id = $arr[array_rand($arr)];
            } else if ($user_id == 3) {
                $arr = [7, 8, 9];
                $group_id = $arr[array_rand($arr)];
            }

            $name = $faker->name;
            \App\Contact::create([
                "name"     => $name,
                "company"  => $faker->company,
                "email"    => $faker->email,
                "phone"    => $faker->phoneNumber,
                "address"  => $faker->address,
                "group_id" => $group_id,
                "user_id"  => $user_id
            ]);

        }

    }


}
