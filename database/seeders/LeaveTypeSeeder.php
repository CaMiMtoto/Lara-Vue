<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        // database/seeders/LeaveTypeSeeder.php
        LeaveType::query()->create([
            'name' => 'Annual',
            'max_days_per_year' => 22,
            'max_days_per_month' => null,
        ]);

        LeaveType::query()->create([
            'name' => 'Monthly',
            'max_days_per_year' => 10,
            'max_days_per_month' => 1,
        ]);

    }
}
