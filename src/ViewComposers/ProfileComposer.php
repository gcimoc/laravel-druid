<?php namespace Genetsis\Druid\ViewComposers;

use Genetsis\Identity;
use Genetsis\URLBuilder;
use Genetsis\Urls\DruidUrl;
use Genetsis\UserApi;
use Illuminate\View\View;

class ProfileComposer
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * ProfileComposer constructor.
     *
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * @param View $view
     * @throws \Genetsis\Druid\Exceptions\IdentityException
     */
    public function compose(View $view)
    {
        \App::make('Druid');

        $view->with('is_connected', Identity::isConnected());
        $view->with('entry_point', Identity::getOAuthConfig()->getDefaultSection());
        if (Identity::isConnected()) {
            $view->with('oid', UserApi::getUserLoggedOid());
            $view->with('edit_account_url',  URLBuilder::create(DruidUrl::EDIT)->get());
            $view->with('logout_url', route('actions.logout'));
        } else {
            $view->with('login_url', URLBuilder::create(DruidUrl::LOGIN)->setScope(Identity::getOAuthConfig()->getDefaultSection())->get());
        }
    }
}
