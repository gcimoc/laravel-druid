<?php namespace Genetsis\Druid\Controllers;

use Genetsis\Druid\Traits\AuthenticatesUsers;
use Genetsis\Identity;
use Illuminate\Routing\Controller as BaseController;
use Genetsis\core\OAuthConfig;
use Illuminate\Http\Request;

class ActionsController extends BaseController
{
    use AuthenticatesUsers;

    public function __construct()
    {
        \App::make('Druid');
    }

    public function index(Request $request) {

        $this->scope = Identity::getOAuthConfig()->getDefaultSection();
        $this->redirect = session('inner_redirection', '/');

        $this->callback($request);

        return redirect($this->redirect, 302);
    }
}
