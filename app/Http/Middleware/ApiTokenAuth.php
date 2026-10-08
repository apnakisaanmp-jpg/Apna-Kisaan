<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $plainToken = $request->bearerToken();

        if (! $plainToken) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $token = DB::table('api_tokens')->where('token_hash', hash('sha256', $plainToken))->first();

        if (! $token) {
            return response()->json(['success' => false, 'message' => 'Invalid token.'], 401);
        }

        $user = User::find($token->user_id);

        if (! $user || ! $user->is_active) {
            return response()->json(['success' => false, 'message' => 'Account disabled.'], 403);
        }

        DB::table('api_tokens')->where('id', $token->id)->update(['last_used_at' => now()]);
        auth()->setUser($user);

        return $next($request);
    }
}
