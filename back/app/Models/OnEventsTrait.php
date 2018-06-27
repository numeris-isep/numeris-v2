<?php

namespace App\Models;

trait OnEventsTrait
{
    protected static function boot()
    {
        parent::boot();

        $instance = new static;

        // Get all observables events, and for each bind the listener "onEventName" if exists
        foreach ($instance->getObservableEvents() as $event) {
            $listener = 'on' . ucfirst($event);
            if (method_exists(static::class, $listener)) {
                static::registerModelEvent($event, [static::class, $listener]);
            }
        }
    }
}