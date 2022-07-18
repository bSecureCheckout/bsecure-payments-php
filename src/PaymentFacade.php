<?php

namespace bSecure\Payments;

use Illuminate\Support\Facades\Facade;

/**
 * @see \bSecure\Payments\Skeleton\SkeletonClass
 */
class PaymentFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bsecure-payments';
    }
}
