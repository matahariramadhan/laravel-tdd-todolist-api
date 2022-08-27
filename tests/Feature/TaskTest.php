<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $task = $this->createTask();
    }

    public function test_fetch_all_tasks_of_a_todo_list()
    {
        $response = $this->getJson(route('task.index'));

        $response->assertOk();
        $this->assertEquals(1, count($response->json()));
    }
}
