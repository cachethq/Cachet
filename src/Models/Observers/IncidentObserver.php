<?php

namespace CachetHQ\Cachet\Models\Observers;

use CachetHQ\Cachet\Models\Service;
use CachetHQ\Cachet\Notifications\NotifierAbstract;

class IncidentObserver
{
    /**
     * When an Incident is saved (created or updated) this event is triggered.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     */
    public function saved($model)
    {
        $services = Service::where('active', 1)->get();

        foreach ($services as $service) {
            $notifier = new NotifierAbstract();
            $classname = 'CachetHQ\\Cachet\\Notifications\\'.$service->properties->notifierName;
            $notifier->setNotifier(new $classname())
                ->setParamsToNotifier($service->properties)
                ->prepareMessage($model)
                ->send();
        }
    }
}
