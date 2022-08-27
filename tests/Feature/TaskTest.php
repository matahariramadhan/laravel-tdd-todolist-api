<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private $task;
    private $list;

    public function setUp(): void
    {
        parent::setUp();

        $this->list = $this->createTodoList();
        $this->task = $this->createTask(['todo_list_id' => $this->list->id]);
    }

    public function test_fetch_all_tasks_of_a_todo_list()
    {
        $response = $this->getJson(route('todo-list.task.index', $this->list->id));

        $response->assertOk();
        $this->assertEquals(1, count($response->json()));
    }

    public function test_store_single_task_of_a_todo_list()
    {
        $task = Task::factory()->make();

        $response = $this->postJson(route('todo-list.task.store', $this->list->id),['title' => $task->title]);

        $response->assertCreated();
        $this->assertDatabaseHas('tasks', ['title' => $task->title,'todo_list_id' => $this->list->id]);
    }

    public function test_delete_single_task_of_todo_list()
    {
        $response = $this->deleteJson(route('task.destroy', $this->task->id));

        $response->assertNoContent();
        $this->assertDatabaseMissing('tasks', ['title' => $this->task->title]);
    }

    public function test_update_single_task_of_a_todo_list()
    {
        $response = $this->patchJson(route('task.update', $this->task->id), ['title' => 'updated title']);

        $response->assertOk();
        $this->assertEquals('updated title', $response['title']);
        $this->assertDatabaseHas('tasks', ['title' => 'updated title']);
    }
}
