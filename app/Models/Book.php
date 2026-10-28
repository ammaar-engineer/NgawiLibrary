<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $published_at
 */
#[Fillable(['name', 'created_by', 'published_at'])]
class Book extends Model
{
    // Tabel books tidak punya kolom updated_at.
    const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'created_by' => 'integer',
            'created_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function borrower(): HasOne
    {
        return $this->hasOne(Borrower::class);
    }
}
