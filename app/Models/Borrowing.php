<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'fine',
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_date' => 'date',
        'returned_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function isOverdue()
    {
        return $this->status === 'borrowed' && Carbon::now()->gt(Carbon::parse($this->due_date));
    }

    public function calculateFine()
    {
        if ($this->status === 'returned' || !$this->isOverdue()) {
            return 0;
        }

        $daysOverdue = Carbon::now()->diffInDays($this->due_date);
        return $daysOverdue * 1000; // Rp 1000 per hari
    }
}
