<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrower;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'menu' => 'all',
            'books' => $this->books(query: Book::query()),
        ]);
    }

    public function mine(): View
    {
        $query = Book::query()
            ->whereHas('borrower', fn ($q) => $q->where('user_id', Auth::id()));

        return view('dashboard', [
            'menu' => 'mine',
            'books' => $this->books(query: $query),
        ]);
    }

    public function borrow(Book $book): RedirectResponse
    {
        if ($book->borrower()->exists()) {
            return back()->withErrors(['book' => 'Buku ini sedang dipinjam.']);
        }

        try {
            Borrower::create(['book_id' => $book->id, 'user_id' => Auth::id()]);
        } catch (QueryException) {
            // Unique index book_id: kalah balapan dengan request lain.
            return back()->withErrors(['book' => 'Buku ini sedang dipinjam.']);
        }

        return back();
    }

    public function returnBook(Book $book): RedirectResponse
    {
        $deleted = $book->borrower()
            ->where('user_id', Auth::id())
            ->delete();

        if (! $deleted) {
            return back()->withErrors(['book' => 'Kamu tidak sedang meminjam buku ini.']);
        }

        return back();
    }

    /**
     * Format data buku + status pinjam untuk dikirim ke React lewat data-books.
     *
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    private function books($query)
    {
        return $query
            ->withExists(['borrower as borrowed'])
            ->withExists(['borrower as borrowed_by_me' => fn ($q) => $q->where('user_id', Auth::id())])
            ->latest('id')
            ->get()
            ->map(fn (Book $book) => [
                'id' => $book->id,
                'name' => $book->name,
                'published_at' => $book->published_at?->toDateString(),
                'borrowed' => (bool) $book->borrowed,
                'borrowed_by_me' => (bool) $book->borrowed_by_me,
            ]);
    }
}
