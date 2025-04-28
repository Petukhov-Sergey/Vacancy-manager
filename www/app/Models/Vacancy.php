<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'published_at',
        'work_date',
        'hours',
        'price'
    ];

    protected $casts = [
        'published_at' => 'date',
        'work_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
