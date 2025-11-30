<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    use HasFactory;    protected $fillable = [ // ← "protected" defines a property inside the class
        'title',
        'excerpt',
        'content',
        'date',
        'author',
        'category',
        'image',
        'readTime',
        'featured',
    ];
}
