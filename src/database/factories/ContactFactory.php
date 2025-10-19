<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake('ja_JP')->name(),
            'email' => fake()->unique()->safeEmail(),
            'title' => '予約方法について',
            'detail' => '来月の21日に3名で1泊予定です。宿泊プランに... detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail',
            'status' => 0,
            'updated_at' => fake()->date(),
            'created_at' => fake()->date(),
        ];
    }
}
