<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\RitmoFactory;

class Ritmo extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return RitmoFactory::new();
    }

    protected $fillable = [
        'nombre',
        'descripcion',
        'bpm_default',
        'created_by',
        'approved',
        'anio',
        'autor',
        'tipo',
        'opcional',
        'anio_opcional',
    ];

    protected $casts = [
        'approved' => 'boolean',
        'bpm_default' => 'integer',
        'anio' => 'integer',
        'opcional' => 'boolean',
    ];

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tambores()
    {
        return $this->belongsToMany(Tambor::class, 'ritmo_tambor');
    }

    public function videos()
    {
        return $this->hasMany(Video::class)->orderBy('orden_ejecucion');
    }

    public function partituras()
    {
        return $this->hasMany(Partitura::class);
    }

    public function scopeAprobados($query)
    {
        return $query->where('approved', true);
    }

    public function scopePendientes($query)
    {
        return $query->where('approved', false);
    }
}

