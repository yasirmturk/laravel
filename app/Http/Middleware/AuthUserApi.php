<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class AuthUserApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if ($response->isOk()) {
            $user = $request->user();
            $customer = $user->createOrGetStripeCustomer();
            $response->setContent([
                'token' => json_decode($response->getContent()),
                'user' => $user,
                // 'customer' => $customer,
                'subscriptions' => $customer->subscriptions->data
            ]);
        }
        return $response;
    }
}
