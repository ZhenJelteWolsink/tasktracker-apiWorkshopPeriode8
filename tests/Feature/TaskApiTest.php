<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Task;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_tasks()
    {
        Task::factory()->count(3)->create();
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(200)
                ->assertJsonCount(3);
    }

    public function test_can_create_a_task()
    {
        $data = [
            'title' => 'Test taak'
        ];

        $response = $this->postJson('/api/tasks', $data);
        $response->assertStatus(201)
                ->assertJsonFragment([
                    'title' => 'Test taak'
                ]);
        $this->assertDatabaseHas('tasks', [
            'title' => 'Test taak'
        ]);
    }
}


