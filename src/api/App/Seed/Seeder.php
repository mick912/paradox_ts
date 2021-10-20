<?php
namespace App\Seed;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAddress;
use Core\Database\Seeder as BaseSeeder;
use Faker\Factory;
use Faker\Generator;

Class Seeder extends BaseSeeder
{

    /**
     * Run the database Seed.
     *
     * @return void
     */
    public function run()
    {

        UserAddress::truncate();
        $faker = Factory::create();
        $this->seedCountries($faker);
        $this->seedCities($faker);
        $this->seedRoles($faker);
        $this->seedDepartments($faker);
        $this->seedUsers($faker);
        $this->seedUserAddress($faker);
    }

    private function seedRoles(Generator $faker)
    {
        Role::query()->delete();
        for ($i = 0; $i < 15; $i++) {
            $role = new Role();
            $role->name = $faker->jobTitle;
            $role->save();
        }
    }

    private function seedCountries(Generator $faker)
    {
        Country::query()->delete();
        for ($i = 0; $i < 50; $i++) {
            Country::create([
                'name' => $faker->country,
                'iso' => $faker->countryISOAlpha3,
            ]);
        }
    }

    private function seedCities(Generator $faker)
    {
        City::query()->delete();
        $countries =  Country::all();
        foreach ($countries as $country) {
            for ($j = 0; $j < 5; $j++) {
                $city = new City();
                $city->name = $faker->city;
                $country->cities()->save($city);
                $city->save();
            }
        }
    }

    private function seedDepartments(Generator $faker)
    {
        Department::query()->delete();
        for ($i = 0; $i < 10; $i++) {
            $department = new Department();
            $department->name =  $faker->company;
            $department->save();
        }
    }

    private function seedUsers(Generator $faker)
    {
        User::query()->delete();
        for ($i = 0; $i < 300; $i++) {
            $role = Role::inRandomOrder()->first();
            $department = Department::inRandomOrder()->first();

            $user = new User();
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->email = $faker->email;
            $user->age = $faker->numberBetween(18, 60);
            $user->department()->associate($department);
            $user->role()->associate($role);
            $user->save();
        }
    }

    private function seedUserAddress(Generator $faker)
    {
        UserAddress::query()->delete();
        $users = User::all();
        foreach ($users as $user) {
            $country = Country::inRandomOrder()->first();
            $city = $country->cities()->first();

            $address = new UserAddress();
            $address->area = $faker->state;
            $address->address = $faker->address;
            $address->user()->associate($user);
            $address->country()->associate($country);
            $address->city()->associate($city);
            $address->save();
        }

    }

}