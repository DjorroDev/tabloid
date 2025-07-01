<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabloid extends Model
{
    use HasFactory;
    use HasFactory;


    protected $fillable = [
        // 'user_id', // Jika ada user yang memiliki proyek
        'title',
    ];

    /**
     * Get the user that owns the tabloid (if applicable).
     */
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    /**
     * Get the pages for the tabloid.
     */
    public function pages()
    {
        // Contoh jika page_number diurutkan
        return $this->hasMany(TabloidPage::class)->orderBy('page_number');
    }

    // Jika Anda ingin relasi ke exported_documents (PDF)
    // public function exportedDocuments()
    // {
    //     return $this->hasMany(ExportedDocument::class);
    // }
}
