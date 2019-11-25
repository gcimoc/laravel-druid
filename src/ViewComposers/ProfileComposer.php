<?php namespace Genetsis\Druid\ViewComposers;

use Genetsis\Identity;
use Genetsis\URLBuilder;
use Genetsis\Urls\DruidUrl;
use Genetsis\UserApi;
use Illuminate\Support\Arr;
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
     * Share to view an entry_point var to load default entry_point page
     *
     * @param View $view
     * @throws \Genetsis\Druid\Exceptions\IdentityException
     */
    public function compose(View $view)
    {
        \App::make('Druid');

        $view->with('is_connected', Identity::isConnected());

        $entry_point = Arr::get($view->getData(), 'entry_point', Identity::getOAuthConfig()->getDefaultSection()) ?? Identity::getOAuthConfig()->getDefaultSection();

        $view->with('entry_point', $entry_point);

        if (Identity::isConnected()) {
            $view->with('edit_account_url',  URLBuilder::create(DruidUrl::EDIT)->get());
            $view->with('logout_url', route('actions.logout'));
        } else {
            $view->with('sso_url', URLBuilder::create(DruidUrl::SSO)->get());
            $view->with('register_url', URLBuilder::create(DruidUrl::REGISTER)->setScope($entry_point)->get());
            $view->with('login_url', URLBuilder::create(DruidUrl::LOGIN)->setScope($entry_point)->get());
        }
    }
}
