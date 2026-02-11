<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partitura extends Model
{
    use HasFactory;

    protected $fillable = [
        'ritmo_id',
        'archivo_pdf',
    ];

    public function ritmo()
    {
        return $this->belongsTo(Ritmo::class);
    }
}

