<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskLists;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        //memanggil seeder
        $this->call(TaskListSeeder::class);
        $this->call(TaskSeeder::class);
    }
}
