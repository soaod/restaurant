<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\RestaurantSetting;
use App\Models\Role;
use App\Models\Table;
use App\Models\TableType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Create Roles [Admin, Employee]
        Role::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'admin'],
                ['name' => 'employee'],
            ))
            ->create()
            ->each(function ($role) {
                User::factory()->count(1)->create([
                    'role_id' => $role->id
                ]);
            });

        $tableTypes = [
            [
                "name" => "Single",
                "seats" => 1
            ],
            [
                "name" => "Double",
                "seats" => 2
            ],
            [
                "name" => "Triple",
                "seats" => 3
            ],
            [
                "name" => "Quadruple",
                "seats" => 4
            ],
            [
                "name" => "Quintuple",
                "seats" => 5
            ],
            [
                "name" => "Sixfold",
                "seats" => 6
            ],
        ];

        foreach ($tableTypes as $tableType) {
            TableType::factory()
                ->count(1)
                ->create([
                    'type' => $tableType['name'],
                    'seats' => $tableType['seats'],
                ])->each(function ($tableType) {
                    Table::factory()->count(2)->create([
                        'table_type_id' => $tableType->id
                    ]);
                });
        }

        Customer::factory()->count(10)->create();

        RestaurantSetting::create([
            "open_at" => "12:00",
            "close_at" => "11:59"
        ]);
    }
}
