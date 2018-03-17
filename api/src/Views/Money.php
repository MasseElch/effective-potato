<?php

namespace App\Views;
use Swagger\Annotations as SWG;

/**
 * Class Money
 * @package App\Views
 *
 * @SWG\Definition()
 */
class Money
{
    /**
     * @var string
     *
     * @SWG\Property()
     */
    public $amount;

    /**
     * @var string
     *
     * @SWG\Property()
     */
    public $currency;
}