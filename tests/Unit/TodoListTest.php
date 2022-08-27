<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    private $list;
    private $task;

    public function setUp(): void
    {
        parent::setUp();

        $this->list = $this->createTodoList();
        $this->task = $this->createTask(['todo_list_id' => $this->list->id]);
    }

    public function test_a_todo_list_can_has_many_tasks()
    {
        $this->assertInstanceOf(Task::class, $this->list->tasks->first());
    }

    public function test_tasks_belong_to_a_todo_list()
    {
        $this->assertInstanceOf(TodoList::class, $this->task->todo_list);
    }
}
