<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTruncation;

    public function test_user_can_get_category()
    {
        Category::factory()->count(15)->create();

        $response = $this->actingAs($this->user)->get(route('category.index',['page'=>1, 'perpage'=>10]));

        $response->assertStatus(200)
                 ->assertJson(['total'=>15])
                 ->assertJsonCount(10, 'data');
    }

    public function test_user_can_save_category()
    {
        $category = Category::factory()->make()->only('name','enable')->toArray();

        $response = $this->actingAs($this->user)->postJson(route('category.store'), $category);

        $response->assertStatus(201)
                 ->assertJson($category);

        $this->assertDatabaseHas('categories', $category);
    }

    public function test_user_can_update_category()
    {
        $category = Category::factory()->create();
        $input = $category->only('name','enable')->toArray();
        $input['name']='New Name';

        $response = $this->actingAs($this->user)->putJson(route('category.update',$category->id), $input);

        $response->assertStatus(200)
                 ->assertJson($input);
        
        $this->assertDatabaseHas('categories', $input);
    }

    public function test_user_can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson(route('category.destroy',$category->id));

        $response->assertStatus(200)
                 ->assertJson($category);
        
        $this->assertDatabaseMissing('categories', ['id'=>$category->id]);
    }
}
