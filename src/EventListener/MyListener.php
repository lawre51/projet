<?php
namespace App\EventListener;


use App\Event\RestrictedRoleEvent;

class MyListener
{

public function onMyEvent(RestrictedRoleEvent $event)
{

var_dump("ok");

}

}