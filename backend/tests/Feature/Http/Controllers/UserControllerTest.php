<?php

namespace Tests\Feature\Http\Controllers;


use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $baseURL;
    protected $baseData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupTestData();
    }

    private function setupTestData(): void
    {
        $this->baseURL = '/api/users/';

        $this->baseData = [
            'role' => 'user',
            'username' => 'test_user_' . Str::random(5), 
            'password' => 'password123',
            'email' => 'test_user_' . Str::random(10) . '@example.com', 
            'shipping_country' => 'Magyarország',
            'shipping_city' => 'Budapest',
            'shipping_zip' => '1111',
            'shipping_street' => 'Test utca 123',
            'shipping_street_number' => 5
        ];
    }

    public function test_can_list_all_users(): void
    {
        $this->createTestUser();
        $this->createTestUser();

        $response = $this->getJson($this->baseURL);
        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_can_get_one_user(): void
    {
        $user = $this->createTestUser();

        $response = $this->getJson($this->baseURL . $user->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $user->id, 'username' => $user->username]);
    }

    public function test_create_user_returns_201_status(): void
    {
        $response = $this->postJson($this->baseURL, $this->baseData);
        $response->assertStatus(201);
    }

    public function test_created_user_is_in_database(): void
    {
        $this->postJson($this->baseURL, $this->baseData);

        $this->assertDatabaseHas('users', [
            'username' => $this->baseData['username'],
            'email' => $this->baseData['email']
        ]);
    }

    public function test_create_user_requires_username(): void
    {
        $data = $this->baseData;
        unset($data['username']);

        $this->postJson($this->baseURL, $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['username']);
    }

    public function test_create_user_requires_email(): void
    {
        $data = $this->baseData;
        unset($data['email']);

        $this->postJson($this->baseURL, $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_create_user_requires_password(): void
    {
        $data = $this->baseData;
        unset($data['password']);

        $this->postJson($this->baseURL, $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_create_user_validates_email_format(): void
    {
        $data = $this->baseData;
        $data['email'] = 'invalid-email-format';

        $response = $this->postJson($this->baseURL, $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function can_update_user_returns_200_status(): void
    {
        $user = User::factory()->create();

        $updateData = [
            'username' => 'updated_user_' . Str::random(5),
            'email' => 'updated_user_' . Str::random(10) . '@example.com',
            'password' => 'updated_password',
            'shipping_country' => 'Magyarország',
            'shipping_city' => 'Szeged',
            'shipping_zip' => '1234',
            'shipping_street' => 'Frissített utca',
            'shipping_street_number' => 25,
        ];

        $response = $this->putJson("$this->baseURL/{$user->id}", $updateData);

        $response->assertStatus(200);
    }


    public function updated_user_is_in_database(): void
    {
        $user = User::factory()->create();

        $updateData = [
            'username' => 'updated_user_' . Str::random(5),
            'email' => 'updated_user_' . Str::random(10) . '@example.com',
            'password' => 'updated_password',
            'shipping_country' => 'Magyarország',
            'shipping_city' => 'Szeged',
            'shipping_zip' => '1234',
            'shipping_street' => 'Frissített utca',
            'shipping_street_number' => 25,
        ];

        $this->putJson("$this->baseURL/{$user->id}", $updateData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => $updateData['username'],
            'email' => $updateData['email'],
        ]);
    }


    public function test_cannot_update_nonexistent_user(): void
    {
        $this->putJson($this->baseURL . '9999', $this->baseData)
            ->assertStatus(404);
    }

    public function can_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("$this->baseURL/{$user->id}");

        $response->assertStatus(204);
    }

    public function test_deleted_user_is_soft_deleted(): void
    {
        $user = $this->createTestUser();

        $this->deleteJson($this->baseURL . $user->id);

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    private function createTestUser(): User
    {
        return User::factory()->create();
    }
}
