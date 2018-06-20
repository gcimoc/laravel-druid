<?php

return array(
    'composer_views' => array('partials.druidinfo','partials.gtm.js', 'partials.gtm.body','partials.gtm_events','errors.404'),
    'event_subscriber' => \Genetsis\Druid\Events\DruidSubscriber::class,
    'callback_controller' => \Genetsis\Druid\Controllers\ActionsController::class
);