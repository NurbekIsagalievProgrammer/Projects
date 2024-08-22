<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $dates = [];
        
        // Задаем один год и генерируем даты за каждый месяц этого года
        for ($month = 1; $month <= 12; $month++) {
            // Генерируем даты в пределах одного месяца
            for ($i = 0; $i < 5; $i++) { // Пять дат на каждый месяц
                $dates[] = $faker->dateTimeBetween('2024-' . $month . '-01', '2024-' . $month . '-31')->format('Y-m-d H:i:s');
            }
        }
        
        sort($dates);
        
        foreach ($dates as $date) {
            DB::table('transactions')->insert([
                'date' => $date,
                'amount' => $faker->randomFloat(2, 0, 1000),
                'type' => $faker->randomElement(['income', 'expense']),
                'details' => $faker->sentence(),
            ]);
        }
        
    }
}
