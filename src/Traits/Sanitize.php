<?php

namespace Aditya\DetikTest\Traits;

/**
 * To sanitize input from user
 */
trait Sanitize
{
    public static function preventInjection($request)
    {
        return htmlspecialchars($request);
    }    
}
