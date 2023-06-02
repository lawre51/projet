<?php

namespace App\Service;

use App\Event\RestrictedRoleEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ServiceEvent
{
    
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {

        $this->eventDispatcher = $eventDispatcher;
    }

    public function runEvent($str): string
    {
            $event = new RestrictedRoleEvent($str);
            $this->eventDispatcher->dispatch($event, RestrictedRoleEvent::NAME);
      
        return $str;
    }

}