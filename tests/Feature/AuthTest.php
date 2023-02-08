<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_login_with_valid_credential()
    {
        $response = $this->postJson(route('auth.login'), [
            'email'=>$this->user->email,
            'password'=>'password'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'status',
                    'token',
                    'data'=>['name']
                  ]);
    }


    public function test_user_can_not_login_with_invalid_credential()
    {
        $response = $this->postJson(route('auth.login'), [
            'email'=>$this->user->email,
            'password'=>'12345678'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'status' =>'FAIL',
                    'message'=>'Unauthorized'
                 ]);
    }

    public function test_user_can_logout_with_valid_credential()
    {
        $response = $this->actingAs($this->user)
                         ->postJson(route('auth.logout'));

        $response->assertStatus(204);
    }
}
