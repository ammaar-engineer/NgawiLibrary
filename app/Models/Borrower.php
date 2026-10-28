<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $book_id
 * @property int $user_id
 */
#[Fillable(['book_id', 'user_id'])]
class Borrower extends Model
{
    protected $table = 'borrower';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'book_id' => 'integer',
            'user_id' => 'integer',
        ];
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
