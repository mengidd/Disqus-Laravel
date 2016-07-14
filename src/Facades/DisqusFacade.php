<?php

namespace Mengidd\Disqus\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mengidd\Disqus\Disqus
 */
class DisqusFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mengidd.disqus';
    }
}
