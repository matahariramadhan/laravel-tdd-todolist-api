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
    
    public function test_store_single_todo_list()
    {
        $list = TodoList::factory()->make();

        $response = $this->postJson(route('todo-list.store'), ['name' => $list->name]);

        $response->assertCreated();
        $this->assertEquals($list->name, $response['name']);
        $this->assertDatabaseHas('todo_lists', ['name' => $list->name]);
    }

    public function test_while_storing_todo_list_name_field_is_required()
    {
        $this->withExceptionHandling();
        $response = $this->postJson(route('todo-list.store'));

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    public function test_delete_single_todo_list()
    {
        $response = $this->deleteJson(route('todo-list.destroy',$this->list->id));

        $response->assertOk();
        $this->assertEquals(true,$response->json());
        $this->assertDatabaseMissing('todo_lists',['name' => $this->list]);
    }

    public function test_update_single_todo_list()
    {
        $response = $this->postJson(route('todo-list.update', $this->list->id).'?_method=PUT', ['name' => 'updated name']);

        $response->assertOk();
        $this->assertDatabaseHas('todo_lists', ['id' => $this->list->id, 'name' => 'updated name']);
    }

    public function test_while_updating_todo_list_name_field_is_required()
    {
        $this->withExceptionHandling();

        $response = $this->postJson(route('todo-list.update', $this->list->id).'?_method=PUT');

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }
}