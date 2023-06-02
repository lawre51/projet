<?php


namespace App\Event;


use Symfony\Contracts\EventDispatcher\Event;

class RestrictedRoleEvent extends Event
{

    public const NAME = 'restricted.role';

    protected $str;

    public function __construct($str)
    {
        $this->str = $str;
    }

    public function getStr(): string {
        return $this->str;
    }

}