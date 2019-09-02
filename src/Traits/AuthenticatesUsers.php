<?php namespace Genetsis\Druid\Traits;

use Genetsis\Identity;
use Genetsis\URLBuilder;
use Genetsis\Urls\DruidUrl;
use Genetsis\UserApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait AuthenticatesUsers
{
    protected $state = '';
    protected $scope = null;
    protected $redirect = '';
    protected $code = '';

    protected function callback(Request $request)
    {
        if (!$request->get('error')) {
            $this->code = $request->get('code', null);

            $this->authorize();

        } else if ($request->get('error') != 'user_cancel') {
            Log::error('ERROR in callback: '.$request->get('error'));
        } else {
            $this->userCancel();
        }
    }

    public function logout(Request $request) {
        event('druiduser.logout', array($request, UserApi::getUserLogged()));

        //Identity::synchronizeSessionWithServer();
        Identity::logoutUser();

        return redirect($this->redirect, 302);
    }

    public function login() {
        return redirect(URLBuilder::create(DruidUrl::LOGIN)->get(), 302);
    }

    public function register() {
        return redirect(URLBuilder::create(DruidUrl::REGISTER)->get(), 302);
    }

    protected function authorize() {
        if (!empty($this->code)) {
            if (!Identity::isConnected()) {
                Identity::authorizeUser($this->code, $this->scope);

                if ($this->scope != null) {
                    if (!Identity::checkUserComplete($this->scope)) {
                        return redirect(URLBuilder::create(DruidUrl::COMPLETE_ACCOUNT)->setScope($this->scope)->setState($this->state)->get(), 302);
                    }
                }
            }
            UserApi::deleteCacheUser();

            event('druiduser.login', UserApi::getUserLogged());
        }
    }

    protected function userCancel() {
        Log::debug('Default Callback with User_Cancel');
    }
}
