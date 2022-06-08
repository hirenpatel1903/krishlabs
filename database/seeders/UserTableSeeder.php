<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name'     => 'John',
            'last_name'      => 'Doe',
            'username'       => 'admin',
            'email'          => 'admin@example.com',
            'phone'          => '+15005550006',
            'address'        => 'Dhaka, Bangladesh',
            'password'       => bcrypt('123456'),
            'remember_token' => Str::random(10),
        ]);
    }
}
