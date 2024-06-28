<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    protected static ?string $password;
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $roles = ['user', 'hod', 'admin', 'super_admin'];

        // $users = [
        //     [
        //         'name' => 'Super Admin',
        //         'department' => env('SUPER_ADMIN_DEPARTMENT'),
        //         'email' => env('SUPER_ADMIN_EMAIL'),
        //         'email_verified_at' => now(),
        //         'password' => static::$password ??= Hash::make(env('SUPER_ADMIN_PASSWORD')),
        //         'remember_token' => Str::random(10),
        //         'role_id' => '4',
        //     ],
        //     [
        //         'name' => env('ADMIN_NAME'),
        //         'department' => env('ADMIN_DEPARTMENT'),
        //         'email' => env('ADMIN_EMAIL'),
        //         'email_verified_at' => now(),
        //         'password' => static::$password ??= Hash::make(env('ADMIN_PASSWORD')),
        //         'remember_token' => Str::random(10),
        //         'role_id' => '3',
        //     ],
        // ];
        
        foreach($roles as $role){
            Role::factory()->create(['name' => $role]);
        }

        User::factory(1)->create();

    }
}