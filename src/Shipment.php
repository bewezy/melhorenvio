<?php

namespace MelhorEnvio;

use MelhorEnvio\Resources\Base;
use MelhorEnvio\Resources\Shipment\Calculator;
use MelhorEnvio\Resources\Shipment\Cart;
use MelhorEnvio\Resources\Shipment\Checkout;

class Shipment extends Base
{
    /**
     * @return Calculator
     */
    public function calculator(): Calculator
    {
        return new Calculator($this);
    }

    public function cart(): Cart
    {
        return new Cart($this);
    }

    public function checkout(): Checkout
    {
        return new Checkout($this);
    }
}
