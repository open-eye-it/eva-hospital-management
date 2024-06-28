<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		User::create([
			'user_id'			=> rand(1000000000, 9999999999),
			'name'				=> 'super_admin',
			'email'				=> 'superadmin@gmail.com',
			'email_verified_at'	=> \Carbon\Carbon::now(),
			'password'			=> 'Google@123',
			'person_name'       => 'Super Admin',
			'contactno'         => 1234567890,
			'address'           => 'EVA hospital, Ahmedabad',
			'added_by'          => rand(1000000000, 9999999999),
			'updated_by'        => rand(1000000000, 9999999999),
			'user_status'       => 1,
			'show_to_doctor_list' => 1,
			'remember_token'	=> Str::random(60),
			'created_at'		=> \Carbon\Carbon::now(),
			'updated_at'		=> \Carbon\Carbon::now(),
		]);
	}
}
