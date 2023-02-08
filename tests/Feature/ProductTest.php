<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseTruncation;

    public function test_user_can_get_product()
    {
        Product::factory()->count(15)->create();

        $response = $this->actingAs($this->user)->get(route('product.index',['page'=>1, 'perpage'=>10]));

        $response->assertStatus(200)
                 ->assertJson(['total'=>15])
                 ->assertJsonCount(10, 'data');
    }

    public function test_user_can_save_product()
    {
        $product = Product::factory()->make()->only('name','description','enable');

        $images = Image::factory()->count(2)->create(['enable'=>1])->pluck('id')->toArray();
        $categories = Category::factory()->count(1)->create(['enable'=>1])->pluck('id')->toArray();

        $response = $this->actingAs($this->user)->postJson(route('product.store'), array_merge($product,['images'=>$images, 'categories'=>$categories]));

        $response->assertStatus(201)
                 ->assertJson($product);

        $this->assertDatabaseHas('products', $product);
    }

    public function test_user_can_update_product()
    {
        $product = Product::factory()->create();

        $images = Image::factory()->count(2)->create(['enable'=>1])->pluck('id')->toArray();
        $categories = Category::factory()->count(1)->create(['enable'=>1])->pluck('id')->toArray();

        $input = $product->only('name','enable');
        $input['name']='New Name';

        $response = $this->actingAs($this->user)->putJson(route('product.update',$product->id), array_merge($input,['images'=>$images, 'categories'=>$categories]));
 
        $response->assertStatus(200)
                 ->assertJson($input);
        
        $this->assertDatabaseHas('products', $input);
    }

    public function test_user_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson(route('product.destroy',$product->id));

        $response->assertStatus(204);
        
        $this->assertDatabaseMissing('products', ['id'=>$product->id]);
    }
}
