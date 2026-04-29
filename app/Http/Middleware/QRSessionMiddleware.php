<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QRSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if QR session data exists
        if (!session()->has('qr_type') || !session()->has('qr_number')) {
            // If accessing cart, checkout, or order pages without QR data, redirect to menu
            if ($request->is('cart/*') || $request->is('checkout/*') || $request->is('order/*')) {
                return redirect()->route('menu.index')
                    ->with('error', 'Silakan scan QR code terlebih dahulu');
            }
        }
        
        return $next($request);
    }
}
