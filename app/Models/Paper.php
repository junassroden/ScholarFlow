<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_source',
        'external_id',
        'doi',
        'title',
        'abstract',
        'journal',
        'publication_year',
        'publication_date',
        'citation_count',
        'pdf_url',
        'language',
    ];

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}