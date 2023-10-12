<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notification::create([
            "user_id" => 38,
            "content" => "Welcome to your dashboard",
            "title" => "New account",
            "isSeen" => false,
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
