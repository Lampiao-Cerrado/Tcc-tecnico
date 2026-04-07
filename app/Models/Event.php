<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'main_image',
        'active'
    ];

    protected $casts = [
        'event_date' => 'date', // ← AQUI resolve o erro!
    ];

    public function images()
    {
        return $this->hasMany(EventImage::class)
                    ->orderBy('position', 'asc');
    }
}
