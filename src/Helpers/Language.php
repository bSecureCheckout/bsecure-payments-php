<?php

namespace bSecure\Payments\Helpers;

class Language
{
    static function getMessage($key)
    {
        return __($key);
    }
}
