<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    // Disable timestamps because your table has only 'created_at' (no 'updated_at')
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'paper_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }
}