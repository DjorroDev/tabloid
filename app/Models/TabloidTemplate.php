<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabloidTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'user_id', // Jika user bisa menyimpan template sendiri
        'name',
        'data', // Jika Anda menyimpan seluruh array layout sebagai JSON/TEXT
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get the user that owns the template (if applicable).
     */
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
