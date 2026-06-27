<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSSProtection
{
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$value) {

            $value = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $value);
            $value = preg_replace('/on\w+="[^"]*"/i', '', $value);
            $value = preg_replace('/javascript:/i', '', $value);
            $value = strip_tags($value, '<b><i><u><br><p><strong><em>'); 
        });

        $request->merge($input);

        return $next($request);
    }
}
