<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_books(): void
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_list_books_returns_empty_array_when_no_books(): void
    {
        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonCount(0);
    }

    public function test_can_create_book(): void
    {
        $bookData = [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'publication_year' => 2024,
        ];

        $response = $this->postJson('/api/books', $bookData);

        $response->assertStatus(201)
            ->assertJsonFragment($bookData);

        $this->assertDatabaseHas('books', $bookData);
    }

    public function test_can_show_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => $book->title,
                'author' => $book->author,
                'publication_year' => $book->publication_year,
            ]);
    }

    public function test_show_book_returns_404_for_nonexistent_book(): void
    {
        $response = $this->getJson('/api/books/999');

        $response->assertStatus(404);
    }

    public function test_can_update_book(): void
    {
        $book = Book::factory()->create();
        $updateData = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'publication_year' => 2023,
        ];

        $response = $this->putJson("/api/books/{$book->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment($updateData);

        $this->assertDatabaseHas('books', $updateData);
    }

    public function test_update_book_validates_required_fields(): void
    {
        $book = Book::factory()->create();
        $response = $this->putJson("/api/books/{$book->id}", []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'author', 'publication_year']);
    }

    public function test_can_delete_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_delete_book_returns_404_for_nonexistent_book(): void
    {
        $response = $this->deleteJson('/api/books/999');

        $response->assertStatus(404);
    }

    public function test_validates_required_fields(): void
    {
        $response = $this->postJson('/api/books', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'author', 'publication_year']);
    }

    public function test_validates_publication_year_range(): void
    {
        $bookData = [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'publication_year' => 1499,
        ];

        $response = $this->postJson('/api/books', $bookData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['publication_year']);
    }
}
