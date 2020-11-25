<?php

use Illuminate\Database\Seeder;

class SchoolPhonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phones = [
            '(XXX) XXX-XXX-XXX'
        ];

        DB::table('school_phones')->insert($phones);
    }
}
