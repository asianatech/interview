<?php
/**
 * User: faiz
 * Date: 4/26/16
 * Time: 3:22 PM
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Muhammad Faiz',
            'email' => 'muhdfaizhalim@gmail.com',
            'password' => bcrypt('123456'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}