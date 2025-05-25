<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserRolesEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // run location seeder
        $this->call([
            LocationSeeder::class,
        ]);

        $userroles = [
            [
                'id' => UserRolesEnum::Customer,
                'name' => 'Salon Customer',
                'status' => true,
            ],
            [
                'id' => UserRolesEnum::Staff,
                'name' => 'Salon Staff',
                'status' => true,
            ],
            [
                'id' => UserRolesEnum::Manager,
                'name' => 'Manager',
                'status' => true,
            ]

        ];

        foreach ($userroles as $role) {
            \App\Models\Role::create($role);
        }

        // Create admin user
        \App\Models\User::create([
            'name' => 'Manager',
            'email' => 'admin@ajhairsalon.com',
            'password' => Hash::make('admin1'),
            'phone_number' => '123456789',
            'role_id' => UserRolesEnum::Manager->value,
        ]);

        // create mock customers
        \App\Models\User::create([
            'name' => 'Customer 1',
            'email' => 'cust1@gmail.com',
            'password' => Hash::make('custpassword'),
            'phone_number' => '1299567890',
            'role_id' => UserRolesEnum::Customer->value,
        ]);

        \App\Models\User::create([
            'name' => 'Customer 2',
            'email' => 'cust2@gmail.com',
            'password' => Hash::make('custpassword'),
            'phone_number' => '1277567890',
            'role_id' => UserRolesEnum::Customer->value,
        ]);

        \App\Models\User::create([
            'name' => 'Customer 3',
            'email' => 'cust3@gmail.com',
            'password' => Hash::make('custpassword'),
            'phone_number' => '1234998890',
            'role_id' => UserRolesEnum::Customer->value,
        ]);

        // this customer is suspeneded
        \App\Models\User::create([
            'name' => 'Customer 4',
            'email' => 'cust4@gmail.com',
            'password' => Hash::make('custpassword'),
            'phone_number' => '2224262890',
            'role_id' => UserRolesEnum::Customer->value,
            'status' => '0',
        ]);



        // create mock employees
        \App\Models\User::create([
            'name' => 'Staff 1',
            'email' => 'staff1@ajhairsalon.com',
            'password' => Hash::make('staff1'),
            'phone_number' => '1644567890',
            'role_id' => UserRolesEnum::Staff->value,
        ]);

        \App\Models\User::create([
            'name' => 'Employee 2',
            'email' => 'emp2@salonbliss.com',
            'password' => Hash::make('emppassword'),
            'phone_number' => '1234523890',
            'role_id' => UserRolesEnum::Staff->value,
        ]);

        // this Employee is suspeneded
        \App\Models\User::create([
            'name' => 'Employee 3',
            'email' => 'emp3@gmail.com',
            'password' => Hash::make('emppassword'),
            'phone_number' => '0034567890',
            'role_id' => UserRolesEnum::Staff->value,
            'status' => '0',
        ]);

        // Deals
        \App\Models\Deal::create([
            'name' => 'Deal 1',
            'description' => 'Deal 1 description',
            'start_date' => '2023-07-16',
            'end_date' => '2023-07-20',
            'discount' => '10',
            'is_hidden' => '0',
        ]);

        // categories Skin, Makeup, Nails, Hair
        \App\Models\Category::create([
            'name' => 'Skin',
        ]);

        \App\Models\Category::create([
            'name' => 'Makeup',
        ]);

        \App\Models\Category::create([
            'name' => 'Hair',
        ]);

        \App\Models\Category::create([
            'name' => 'Nails',
        ]);

        $this->call([
            ServicesSeeder::class,
            TimeSlotSeeder::class,
            LoyaltySettingsSeeder::class,
        ]);


    }
}
