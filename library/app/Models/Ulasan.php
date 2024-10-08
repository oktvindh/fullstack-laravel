<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Ulasan extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'ulasan';
    protected $fillable = [
        'rating',
        'komentar',
        'users_id',
        'buku_id'
    ];
}
