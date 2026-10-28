<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_user_can_borrow_book(): void
    {
        $user = User::factory()->create();
        $book = Book::create(['name' => 'Buku A', 'created_by' => $user->id]);

        $this->actingAs($user)->post("/books/{$book->id}/borrow")->assertRedirect();

        $this->assertDatabaseHas('borrower', ['book_id' => $book->id, 'user_id' => $user->id]);
    }

    public function test_cannot_borrow_book_twice(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $book = Book::create(['name' => 'Buku A', 'created_by' => $user->id]);

        $this->actingAs($user)->post("/books/{$book->id}/borrow");
        $this->actingAs($other)->post("/books/{$book->id}/borrow")->assertSessionHasErrors('book');

        $this->assertDatabaseCount('borrower', 1);
    }

    public function test_my_books_only_lists_books_i_borrowed(): void
    {
        $user = User::factory()->create();
        $mine = Book::create(['name' => 'Punyaku', 'created_by' => $user->id]);
        Book::create(['name' => 'Bukan punyaku', 'created_by' => $user->id]);

        $this->actingAs($user)->post("/books/{$mine->id}/borrow");

        $this->actingAs($user)
            ->get('/dashboard/my-books')
            ->assertOk()
            ->assertSee('Punyaku')
            ->assertDontSee('Bukan punyaku');
    }

    public function test_user_can_return_borrowed_book(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $book = Book::create(['name' => 'Buku A', 'created_by' => $user->id]);

        $this->actingAs($user)->post("/books/{$book->id}/borrow");
        $this->actingAs($user)->post("/books/{$book->id}/return")->assertRedirect();

        $this->assertDatabaseCount('borrower', 0);

        // Setelah dikembalikan, buku bisa dipinjam lagi oleh user lain.
        $this->actingAs($other)->post("/books/{$book->id}/borrow");
        $this->assertDatabaseHas('borrower', ['book_id' => $book->id, 'user_id' => $other->id]);
    }

    public function test_user_cannot_return_book_not_borrowed_by_them(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $book = Book::create(['name' => 'Buku A', 'created_by' => $owner->id]);

        $this->actingAs($owner)->post("/books/{$book->id}/borrow");

        $this->actingAs($intruder)->post("/books/{$book->id}/return")->assertSessionHasErrors('book');

        $this->assertDatabaseHas('borrower', ['book_id' => $book->id, 'user_id' => $owner->id]);
    }
}
