<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Database\Factories\TodoListFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    private $list;

    public function setUp(): void
    {
        parent::setUp();

        $this->list = TodoList::factory()->create(['name' => 'my-list']);
    }

    public function test_fetch_all_todo_list()
    {
        $response = $this->getJson(route('todo-list.index'));
        
        // assert jumlah keseluruhan dan isi object tiap todo-list
        $this->assertEquals(1, count($response->json()));
        $this->assertEquals('my-list', $response->json()[0]['name']);
    }

    public function test_fetch_single_todo_list()
    {
        $response = $this->getJson(route('todo-list.show', $this->list->id));

        $response->assertOk();
        $this->assertEquals($this->list->name,$response->json()['name']);
    }
}
