<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => 'password',
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => 'password',
                'role' => 'user',
            ]
        );

        $rooms = [
            ['room_name' => 'Advanced Chemistry Lab', 'type' => 'lab', 'capacity' => 24, 'status' => 'active'],
            ['room_name' => 'Digital Media Studio', 'type' => 'studio', 'capacity' => 12, 'status' => 'active'],
            ['room_name' => 'Physics Research Lab', 'type' => 'lab', 'capacity' => 18, 'status' => 'active'],
            ['room_name' => 'Photography Studio B', 'type' => 'studio', 'capacity' => 10, 'status' => 'maintenance'],
        ];

        foreach ($rooms as $room) {
            Room::firstOrCreate(
                ['room_name' => $room['room_name']],
                array_merge($room, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        $timeSlots = [
            ['start_time' => '08:00:00', 'end_time' => '10:00:00'],
            ['start_time' => '10:15:00', 'end_time' => '12:15:00'],
            ['start_time' => '13:00:00', 'end_time' => '15:00:00'],
            ['start_time' => '15:15:00', 'end_time' => '17:15:00'],
            ['start_time' => '17:30:00', 'end_time' => '19:30:00'],
        ];

        foreach ($timeSlots as $slot) {
            TimeSlot::firstOrCreate(
                ['start_time' => $slot['start_time'], 'end_time' => $slot['end_time']],
                array_merge($slot, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
