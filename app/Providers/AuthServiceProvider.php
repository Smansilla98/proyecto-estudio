<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Ritmo;
use App\Models\Video;
use App\Models\Partitura;
use App\Policies\RitmoPolicy;
use App\Policies\VideoPolicy;
use App\Policies\PartituraPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Ritmo::class => RitmoPolicy::class,
        Video::class => VideoPolicy::class,
        Partitura::class => PartituraPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}

