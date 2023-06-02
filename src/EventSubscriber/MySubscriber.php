<?php

namespace App\EventSubscriber;

use App\Event\RestrictedRoleEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class MySubscriber implements EventSubscriberInterface
{
    

    public function onRestrictedRole($string)
    {
        ?>
        <div class="alert-info">Vous n'êtes pas autorisé à accéder à cette page réservée aux administrateurs. Vous avez été redigé vers la page accueil</div>
        <?php
    }

    public static function getSubscribedEvents(): array
    {
        return [
            
            RestrictedRoleEvent::NAME => 'onRestrictedRole'
        ];
    }
}