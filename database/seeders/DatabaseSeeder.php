<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Order;
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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $sourse = [
            "Шахматы",
            "Шашки",
            "Го",
            "Карточные игры",
            "Настольный теннис",
            "Баскетбол",
            "Волейбол",
            "Художественная гимнастика",
            "Рисование акварелью",
            "Рисование маслом",
            "Лепка из глины",
            "Бисероплетение",
            "Вышивание",
            "Вязание",
            "Бадминтон",
            "Йога",
            "Плавание",
        ];

        $orders = [
            [
                'course_id' => 5,
                'user_id' => 2,
                'date' => '10.10.2100',
                'status' => 'new',
                'pay' => 'translation',
            ],
            [
                'course_id' => 8,
                'user_id' => 2,
                'date' => '10.10.2100',
                'status' => 'new',
                'pay' => 'cash',
            ],
            [
                'course_id' => 9,
                'user_id' => 2,
                'date' => '10.10.2100',
                'status' => 'active',
                'pay' => 'translation',
            ],
            [
                'course_id' => 3,
                'user_id' => 2,
                'date' => '10.10.2100',
                'status' => 'new',
                'pay' => 'cash',
            ],
            [
                'course_id' => 12,
                'user_id' => 2,
                'date' => '10.10.2100',
                'status' => 'new',
                'pay' => 'cash',
            ],
            [
                'course_id' => 15,
                'user_id' => 2,
                'date' => '10.10.2100',
                'status' => 'completed',
                'pay' => 'cash',
            ],
            [
                'course_id' => 16,
                'user_id' => 2,
                'date' => '10.10.2100',
                'status' => 'active',
                'pay' => 'translation',
            ],
            [
                'course_id' => 17,
                'user_id' => 2,
                'date' => '10.10.2100',
                'status' => 'completed',
                'pay' => 'cash',
            ],
            [
                'course_id' => 13,
                'user_id' => 2,
                'date' => '10.10.2100',
                'status' => 'active',
                'pay' => 'translation',
            ],
            [
                'course_id' => 1,
                'user_id' => 2,
                'date' => '10.10.2100',
                'status' => 'completed',
                'pay' => 'cash',
            ],
        ];

        $users = [
            [
                'fio' => 'Admin',
                'phone' => '+7(999)999-99-99',
                'email' => 'admin@email.com',
                'role' => 'admin',
                'login' => 'Admin',
                'password' => 'KorokNET',
            ],
            // [
            //     'fio' => 'Иванов Иван Иванович',
            //     'phone' => '+7(999)999-99-99',
            //     'email' => 'Ivan@email.com',
            //     'login' => 'ivan',
            //     'password' => 'ivan',
            // ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        foreach ($sourse as $value) {
            Course::create([
                'name' => $value,
            ]);
        }

        // foreach ($orders as $order) {
        //     Order::create($order);
        // }
    }
}
