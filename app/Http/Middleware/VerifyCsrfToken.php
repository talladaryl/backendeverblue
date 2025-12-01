<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyApiCsrf extends Middleware
{
    protected $except = [
        'api/*', // toutes les routes api sont ignorées pour CSRF
    ];
}