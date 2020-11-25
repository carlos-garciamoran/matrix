<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Advisor')->create([
            'user_id' => factory('App\User')->create([
                'email' => 'matrix@uwcisak.jp', 'role' => 'advisor', 'admin' => true
            ])->id,
            'duty' => true
        ]);

        factory('App\Student')->create([
            'user_id' => factory('App\User')->create([
                'email' => 'student@uwcisak.jp', 'role' => 'student'
            ])->id
        ]);

        DB::table('advisories')->insert(['advisor_id' => 1, 'student_id' => 2]);
    }
}
