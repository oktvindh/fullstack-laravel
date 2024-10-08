<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kategoris extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'kategori';
    protected $fillable = [
        'nama'
    ];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'kategori_id', 'id');
    }
}
