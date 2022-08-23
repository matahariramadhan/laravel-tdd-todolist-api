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

    public function test_fetch_all_todo_list()
    {
        // buat todo-list di database agar bisa difetch
        TodoList::factory()->create(['name' => 'my-list']);

        $response = $this->getJson(route('todo-list.index'));
        
        // assert jumlah keseluruhan dan isi object tiap todo-list
        $this->assertEquals(1, count($response->json()));
        $this->assertEquals('my-list', $response->json()[0]['name']);
    }

    public function test_fetch_single_todo_list()
    {
        $list = TodoList::factory()->create();

        $response = $this->getJson(route('todo-list.show', $list->id));

        $response->assertOk();
        $this->assertEquals($list->name,$response->json()['name']);
    }
}
