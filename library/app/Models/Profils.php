<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Profils extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'profil';
    protected $fillable = [
        'umur',
        'biodata',
        'alamat',
        'users_id'
    ];
}
