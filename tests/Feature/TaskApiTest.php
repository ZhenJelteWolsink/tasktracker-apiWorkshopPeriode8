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

    public function test_can_update_task_description()
    {
        $task = Task::factory()->create([
            'title' => 'Oude omschrijving'
        ]);

        $response = $this->putJson('/api/task/' . $task->id, [
            'title' => 'Nieuwe omschrijving'
        ]);

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'title' => 'Nieuwe omschrijving'
                ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Nieuwe omschrijving'
        ]);
    }

    public function test_can_mark_task_complete()
    {
        $task = Task::factory()->create([
            'is_done' => false
        ]);

        $response = $this->putJson('/api/task/' . $task->id . '/complete');

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_done' => true
        ]);
    }

    public function test_can_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson('/api/task/' . $task->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }

    public function test_can_get_completed_tasks()
    {
        $completedTask = Task::factory()->create([
            'is_done' => true
        ]);
        $incompleteTask = Task::factory()->create([
            'is_done' => false
        ]);

        $response = $this->getJson('/api/task/complete');

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'id' => $completedTask->id,
                    'is_done' => 1
                ])
                ->assertJsonMissing([
                    'id' => $incompleteTask->id
                ]);
    }
}


