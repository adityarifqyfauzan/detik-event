<?php

namespace Aditya\DetikTest\Helper;

class TicketCodeGenerator
{
    public static function generate() {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 7; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return 'DTX'. $randomString;
    }    
}
