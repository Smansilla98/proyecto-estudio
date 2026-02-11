<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'ritmo_id',
        'tambor_id',
        'url_video',
        'orden_ejecucion',
    ];

    protected $casts = [
        'orden_ejecucion' => 'integer',
    ];

    public function ritmo()
    {
        return $this->belongsTo(Ritmo::class);
    }

    public function tambor()
    {
        return $this->belongsTo(Tambor::class);
    }
}

