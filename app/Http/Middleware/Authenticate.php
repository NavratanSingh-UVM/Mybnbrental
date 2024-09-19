<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if($request->is('owner/*')):
            return $request->expectsJson() ? null : route('frontend.index'); 
        elseif($request->is('traveller/*')):
            return $request->expectsJson() ? null : route('frontend.index'); 
        elseif($request->is('partner/*')):
            return $request->expectsJson() ? null : route('frontend.index');    
        else:
            return $request->expectsJson() ? null : route('admin.login'); 
        endif;
         
    }
}
