<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $userAdmin = User::where('nama', 'admin')->first();
        if($user && $user->id === $userAdmin->id){
            return $next($request);
        }
        
        return response()->json([
            "message" => "Anda tidak dapat mengakses halaman admin",
        ], 401);
    }
}
