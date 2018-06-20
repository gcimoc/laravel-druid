<?php namespace Genetsis\Druid\ViewComposers;

use Genetsis\Identity;
use Genetsis\URLBuilder;
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
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        \App::make('Druid');

        $view->with('is_connected', Identity::isConnected());
        $view->with('entry_point', \View::shared('ENTRY_POINT'));
        if (Identity::isConnected()) {
            $view->with('oid', UserApi::getUserLoggedOid());
            $view->with('edit_account_url', URLBuilder::getUrlEditAccount());
            $view->with('logout_url', route('actions.logout'));
        } else {
            $view->with('login_url', URLBuilder::getUrlLogin(\View::shared('ENTRY_POINT'), null, null, array(), \View::shared('sponsorcode')));
        }
    }
}