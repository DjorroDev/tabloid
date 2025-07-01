<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabloidPage extends Model
{
    use HasFactory;


    protected $fillable = [
        'tabloid_id',
        'page_number',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get the tabloid that owns the page.
     */
    public function tabloid()
    {
        return $this->belongsTo(Tabloid::class);
    }
}
