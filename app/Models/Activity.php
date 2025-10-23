<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'date',
        'duration_minutes',
        'category',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Usuario que subió/creó la actividad (created_by)
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
