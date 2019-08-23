<?php

namespace Genetsis\Druid\Middleware;

use Closure;
use Genetsis\Identity;
use Genetsis\URLBuilder;

class UserLogged
{

    public function handle($request, Closure $next, $festival = null, $promo = null)
    {
        \App::make('Druid');
        $sponsorcode = $request->sponsorcode;

        if (!Identity::isConnected()) {
            return redirect(URLBuilder::getUrlRegister(env(strtoupper($festival).'_PROMOTION_ENTRYPOINT'),null, array(), base64_encode(json_encode(compact('festival', 'promo', 'sponsorcode')))));
        } else {
            if (!Identity::checkUserComplete(env(strtoupper($festival).'_PROMOTION_ENTRYPOINT'))){
                return redirect(URLBuilder::getUrlCompleteAccount(env(strtoupper($festival).'_PROMOTION_ENTRYPOINT'),null, base64_encode(json_encode(compact('festival', 'promo', 'sponsorcode')))));
            }
        }

        return $next($request);
    }
}
