<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
			['name' => 'Basic', 'price' => 1000],
			['name' => 'Car Wash', 'price' => 1500],
			['name' => 'Premium Polish', 'price' => 2000],
			['name' => 'Charge Battery', 'price' => 3000],
		];

		DB::table('services')->insert($services);
    }
}
