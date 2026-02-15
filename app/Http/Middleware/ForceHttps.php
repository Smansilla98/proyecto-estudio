<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Forzar HTTPS en producción
        if (config('app.env') === 'production' || $request->header('X-Forwarded-Proto') === 'https') {
            $request->server->set('HTTPS', 'on');
        }

        $response = $next($request);

        // Si es una respuesta HTML, reemplazar URLs HTTP por HTTPS en assets
        if ($response->headers->get('Content-Type') && str_contains($response->headers->get('Content-Type'), 'text/html')) {
            $content = $response->getContent();
            if ($content && is_string($content)) {
                $host = $request->getHost();
                
                // Reemplazar URLs HTTP por HTTPS en el contenido
                // Patrones comunes de assets de Vite
                $patterns = [
                    '/(href|src)=["\']http:\/\/([^"\']+)["\']/i' => '$1="https://$2"',
                    '/http:\/\/' . preg_quote($host, '/') . '/i' => 'https://' . $host,
                ];
                
                foreach ($patterns as $pattern => $replacement) {
                    $content = preg_replace($pattern, $replacement, $content);
                }
                
                $response->setContent($content);
            }
        }

        return $response;
    }
}

