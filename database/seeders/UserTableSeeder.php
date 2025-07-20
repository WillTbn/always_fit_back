<?php

namespace Database\Seeders;

use App\Models\ProgressLog;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->call(TrainingTableSeeder::class);
        $training = Training::all();
        $users = [
            [
                'name' => 'Jorge Nunes',
                'email' => 'user1@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Fulano de Tal',
                'email' => 'user2@example.com',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($users as $userData) {
            $createdUser = User::factory()->create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
            ]);
            echo "User created: {$createdUser->name} ({$createdUser->email})\n";
            foreach ($training as $train) {
                ProgressLog::factory()->create([
                    'user_id' => $createdUser->id,
                    'training_id' => $train->id,
                    'progress' => rand(1, 25),
                ]);
            }
        }
    }
}
