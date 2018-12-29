<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Author;

class AuthorTest extends TestCase
{
    public function testsAuthorsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'name' => 'My Name',
        ];

        $this->json('POST', '/api/authors', $payload, $headers)
            ->assertStatus(201)
            ->assertJson(['id' => 1, 'name' => 'My Name']);
    }

    public function testsAuthorsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $author = factory(Author::class)->create([
            'name' => 'My New Name',
        ]);

        $payload = [
            'name' => 'My Old Name',
        ];

        $response = $this->json('PUT', '/api/authors/' . $author->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([ 
                'id' => 1, 
                'name' => 'My Old Name',
            ]);
    }

    public function testsAuthorsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $author = factory(Author::class)->create([
            'name' => 'My Name',
        ]);

        $this->json('DELETE', '/api/authors/' . $author->id, [], $headers)
            ->assertStatus(204);
    }

    public function testAuthorsAreListedCorrectly()
    {
        factory(Author::class)->create([
            'name' => 'My Name',
        ]);

        factory(Author::class)->create([
            'name' => 'Your Name',
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/authors', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [ 'name' => 'My Name' ],
                [ 'name' => 'Your Name' ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'name', 'created_at', 'updated_at'],
            ]);
    }
}
