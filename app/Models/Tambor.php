<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\TamborFactory;

class Tambor extends Model
{
    use HasFactory;

    protected $table = 'tambores';

    protected static function newFactory()
    {
        return TamborFactory::new();
    }

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function ritmos()
    {
        return $this->belongsToMany(Ritmo::class, 'ritmo_tambor');
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}

