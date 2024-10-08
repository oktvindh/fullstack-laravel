<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Buku extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'buku';
    protected $fillable = [
        'title',
        'deskripsi',
        'poster',
        'tahun',
        'kategori_id'
    ];

    public function kategori() 
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}
