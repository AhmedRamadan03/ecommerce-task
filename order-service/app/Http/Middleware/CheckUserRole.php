<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // استعلام User Service عن بيانات المستخدم
        $response = Http::withToken($token)
            ->get('http://user-service:9000/api/auth/profile');
        if ($response->failed()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        

        $user = $response->json();
    
        if (! in_array($user['data']['user']['role'], $roles)) {
            return response()->json(['message' => 'Forbidden: Access denied'], 403);
        }
        $request->merge(['user' => $user['data']['user']]);

        return $next($request);
    }
}
