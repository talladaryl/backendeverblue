<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedOrigins = [
            'http://localhost:3000',
            'http://localhost:8080',
            'http://127.0.0.1:3000',
            'http://127.0.0.1:8080',
        ];

        $origin = $request->header('Origin');

        // Vérifier si l'origine est autorisée
        $isAllowed = in_array($origin, $allowedOrigins);

        // Gérer les requêtes OPTIONS (preflight)
        if ($request->getMethod() === 'OPTIONS') {
            if ($isAllowed) {
                return response()
                    ->header('Access-Control-Allow-Origin', $origin)
                    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
                    ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin, X-CSRF-TOKEN')
                    ->header('Access-Control-Max-Age', '86400')
                    ->header('Access-Control-Allow-Credentials', 'true')
                    ->setStatusCode(200);
            }
            return response()->setStatusCode(403);
        }

        // Ajouter les headers CORS à la réponse
        $response = $next($request);

        if ($isAllowed) {
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
            $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin, X-CSRF-TOKEN');
            $response->header('Access-Control-Allow-Credentials', 'true');
            $response->header('Access-Control-Expose-Headers', 'Content-Length, X-JSON-Response-Code');
        }

        return $response;
    }
}
