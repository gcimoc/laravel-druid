<?php namespace Genetsis\Druid\Events;



class DruidSubscriber
{

    /**
     * Handle user login events.
     */
    public function onUserLogin() {

    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout() {

    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        if (config('druid_config.config.event_subscriber')) {
            $events->listen('druiduser.login', config('druid_config.config.event_subscriber').'@onUserLogin');
            $events->listen('druiduser.logout', config('druid_config.config.event_subscriber').'@onUserLogout');
        }
    }
}
