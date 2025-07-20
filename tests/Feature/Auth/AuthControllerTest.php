<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test successful authentication
     */
    public function test_auth_success_with_valid_credentials()
    {

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);


        $response = $this->postJson('/api/auth', [
            'email' => $user->email,
            'password' => 'password123'
        ]);


        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Login efetuado com sucesso.'
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'token'
            ]);
        $this->assertNotEmpty($response->json('token'));
    }

    /**
     * Test authentication failure with invalid email
     */
    public function test_auth_fails_with_invalid_email()
    {

        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);


        $response = $this->postJson('/api/auth', [
            'email' => 'wrong@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Email ou senha inválidos.'
            ]);
    }

    /**
     * Test authentication failure with invalid password
     */
    public function test_auth_fails_with_invalid_password()
    {
        $user =User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);


        $response = $this->postJson('/api/auth', [
            'email' => $user->email,
            'password' => 'wrongpassword'
        ]);


        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Email ou senha inválidos.'
            ]);
    }

    /**
     * Test authentication validation - missing email
     */
    public function test_auth_validation_missing_email()
    {
        $response = $this->postJson('/api/auth', [
            'password' => 'password123'
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'O campo email é obrigatório.'
            ])
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Test authentication validation - missing password
     */
    public function test_auth_validation_missing_password()
    {
        $response = $this->postJson('/api/auth', [
            'email' => 'test@example.com'
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'message' => 'O campo senha é obrigatório.'
            ])
            ->assertJsonValidationErrors(['password']);
    }

    /**
     * Test authentication validation - invalid email format
     */
    public function test_auth_validation_invalid_email_format()
    {
        $response = $this->postJson('/api/auth', [
            'email' => 'invalid-email',
            'password' => 'password123'
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'O formato do email é inválido.'
            ])
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Test that old tokens are deleted when new authentication occurs
     */
    public function test_auth_deletes_old_tokens()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $oldToken = $user->createToken('old_token');

        $response = $this->postJson('/api/auth', [
            'email' => $user->email,
            'password' => 'password123'
        ]);


        $response->assertStatus(200);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $oldToken->accessToken->id
        ]);
    }

    /**
     * Test authentication with empty credentials
     */
    public function test_auth_with_empty_credentials()
    {
        $response = $this->postJson('/api/auth', []);


        $response->assertStatus(422)
            ->assertJson([
                'message' => 'O campo email é obrigatório. (and 1 more error)'
            ])
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * Test logout functionality
     */
    public function test_logout_functionality()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logout efetuado com sucesso.'
            ]);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => 'App\Models\User'
        ]);
    }

    /**
     * Test token validation
     */
    public function test_validate_token()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/auth/validate-token');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Token válido.',
                'user' => [
                    'name' => $user->name,
                    'hash_id' => $user->hash_id,
                    'email' => $user->email,
                ]
            ]);
    }

    public function test_register_user_success()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Usuário registrado, com sucesso.',
                'user' => [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                ]
            ]);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    public function test_register_user_validation()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'notmatching'
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'O campo nome é obrigatório. (and 3 more errors)'
            ])
            ->assertJsonValidationErrors([
                'name',
                'email',
                'password',
            ]);
    }

}
