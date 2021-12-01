<?php

namespace MelhorEnvio\Resources\Shipment;

use GuzzleHttp\Exception\ClientException;
use MelhorEnvio\Exceptions\CalculatorException;
use MelhorEnvio\Exceptions\InvalidResourceException;
use MelhorEnvio\Resources\Resource;
use phpDocumentor\Reflection\Types\This;


/**
 *
 */
class Checkout
{

    /**
     * @var array
     */
    protected $order;

    /**
     * @var Resource
     */
    protected $resource;

    /**
     * @param $resource
     */
    public function __construct($resource)
    {
        if (! $resource instanceof Resource) {
            throw new InvalidResourceException;
        }

        $this->resource = $resource;
    }

    /**
     * @param $order
     * @return bool
     */
    public function addOrder($order): bool
    {
        $this->order[] = $order;
        return true;
    }

    /**
     * @throws CalculatorException
     */
    public function checkout()
    {
        $this->validateOrders();

        try {
            $response = $this->resource->getHttp()->post('me/shipment/checkout', [
                'json' => ["orders" => $this->order],
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (ClientException $exception) {
            throw new CalculatorException($exception);
        }

    }

    /**
     * @throws CalculatorException
     */
    public function preview()
    {
        $this->validateOrders();

        try {
            $response = $this->resource->getHttp()->post('me/shipment/preview', [
                'json' => ["orders" => $this->order],
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (ClientException $exception) {
            throw new CalculatorException($exception);
        }

    }

    /**
     * @throws CalculatorException
     */
    public function generate()
    {
        $this->validateOrders();

        try {
            $response = $this->resource->getHttp()->post('me/shipment/generate', [
                'json' => ["orders" => $this->order],
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (ClientException $exception) {
            throw new CalculatorException($exception);
        }
    }

    /**
     * @throws CalculatorException
     */
    public function print()
    {
        $this->validateOrders();

        try {
            $response = $this->resource->getHttp()->post('me/shipment/print', [
                'json' => [
                    "mode" => "private",
                    "orders" => $this->order
                ],
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (ClientException $exception) {
            throw new CalculatorException($exception);
        }
    }

    /**
     * @throws CalculatorException
     */
    public function tracking()
    {
        $this->validateOrders();

        try {
            $response = $this->resource->getHttp()->post('me/shipment/tracking', [
                'json' => [
                    "orders" => $this->order
                ],
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (ClientException $exception) {
            throw new CalculatorException($exception);
        }
    }

    /**
     * @throws CalculatorException
     */
    private function validateOrders()
    {
        if($this->order) {
            if (count($this->order) < 1) {
                throw new CalculatorException("Você precisa selecionar uma order de checkout válida");
            }
        }
    }

    /**
     * @return array
     */
    public function getOrders(): array
    {
        return $this->order;
    }

}