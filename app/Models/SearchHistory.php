<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use HasFactory;

    protected $table = 'search_history';

    // Disable timestamps – you have 'searched_at' instead
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'keyword',
        'searched_at',
    ];

    // 👇 THIS IS THE FIX – cast 'searched_at' to a Carbon instance
    protected $casts = [
        'searched_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}