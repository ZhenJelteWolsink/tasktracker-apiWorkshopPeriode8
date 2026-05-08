<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Task;

class TaskFactory extends Factory

{

    protected $model = Task::class;

    public function definition(): array

    {

        return [

            'title' => fake()->sentence(3),

            'is_done' => false,

        ];

    }

}