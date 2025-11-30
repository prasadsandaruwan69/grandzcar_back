<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Reviews extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'title', 'rating', 'text', 'image',
        'category',  'verified',
    ];

  
    /** Full URL for the image (used by React) */
 

    /** Human-readable “2 weeks ago” */

}