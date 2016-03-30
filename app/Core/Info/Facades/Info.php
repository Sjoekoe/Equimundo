<?php
namespace EQM\Core\Info\Facades;

use Illuminate\Support\Facades\Facade;

class Info extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \EQM\Core\Info\Info::class;
    }
}
