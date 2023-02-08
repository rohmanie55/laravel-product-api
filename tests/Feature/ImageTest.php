<?php

namespace Tests\Feature;

use App\Models\Image;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_get_image()
    {
        Image::factory()->count(15)->create();

        $response = $this->actingAs($this->user)->get(route('image.index',['page'=>1, 'perpage'=>10]));

        $response->assertStatus(200)
                 ->assertJson(['total'=>15])
                 ->assertJsonCount(10, 'data');
    }

    public function test_user_can_save_image()
    {
        $image = Image::factory()->make()->only('name','enable');

        $response = $this->actingAs($this->user)->postJson(route('image.store'), array_merge($image, ['file'=>UploadedFile::fake()->image('file_101.jpg')]));

        $response->assertStatus(201)
                 ->assertJson($image);

        $this->assertDatabaseHas('images', $image);
    }

    public function test_user_can_update_image()
    {
        $image = Image::factory()->create();
        $input = $image->only('name','enable');
        $input['name']='New Name';

        $response = $this->actingAs($this->user)->putJson(route('image.update',$image->id), $input);

        $response->assertStatus(200)
                 ->assertJson($input);
        
        $this->assertDatabaseHas('images', $input);
    }

    public function test_user_can_delete_image()
    {
        $image = Image::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson(route('image.destroy',$image->id));

        $response->assertStatus(204);
        
        $this->assertDatabaseMissing('images', ['id'=>$image->id]);
    }
}
