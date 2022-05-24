<?php

namespace App\Http\Middleware;

use App\Models\MasterKey;
use Closure;
use Illuminate\Http\Request;

class MasterKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $key = $request->header('Authorization');
        $strKey= trim($key,"Bearer ");

        $keyDb = MasterKey::select("*")
                ->where('key', $strKey)->get();

        if($keyDb->isEmpty()){
            return response()->json(['status' => 'Authorization Token not found'], 401);
        } else {
            return $next($request);
            // return response()->json(['data' => $keyDb], 200);
        }
        
    }
}
