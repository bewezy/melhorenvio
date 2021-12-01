<?php

namespace MelhorEnvio\Resources\Shipment;

use GuzzleHttp\Exception\ClientException;
use MelhorEnvio\Exceptions\CalculatorException;
use MelhorEnvio\Exceptions\InvalidCalculatorPayloadException;
use MelhorEnvio\Exceptions\InvalidResourceException;
use MelhorEnvio\Exceptions\InvalidVolumeException;
use MelhorEnvio\Resources\Resource;
use InvalidArgumentException;
use MelhorEnvio\Validations\Location;
use MelhorEnvio\Validations\Number;

/**
 *
 */
class Cart
{

    /**
     * @var array
     */
    protected $payload = [];

    /**
     * @var Resource
     */
    protected $resource;

    /**
     * @var
     */
    protected $activeRegister;

    /**
     * New Calculate instance.
     * @param $resource
     * @throws InvalidArgumentException
     */
    public function __construct($resource)
    {
        if (! $resource instanceof Resource) {
            throw new InvalidResourceException;
        }

        $this->resource = $resource;
    }

    /**
     * @param int $service
     */
    public function service(int $service)
    {
        if (! is_int($service)) {
            throw new InvalidArgumentException('service');
        }
        $this->payload['service'] = $service;
    }

    /**
     * @param int $agency
     */
    public function agency(int $agency)
    {
        if (! is_int($agency)) {
            throw new InvalidArgumentException('agency');
        }
        $this->payload['agency'] = $agency;
    }

    /**
     * @param $postalCode
     */
    public function from($postalCode)
    {
        $this->addPostalCodeInPayload('from', $postalCode);
    }

    /**
     * @param $postalCode
     */
    public function to($postalCode)
    {
        $this->addPostalCodeInPayload('to', $postalCode);
    }

    /**
     * @param $key
     * @param $postalCode
     */
    protected function addPostalCodeInPayload($key, $postalCode)
    {
        if (! $this->isValidPostalCode($postalCode)) {
            throw new InvalidArgumentException($key);
        }

        $this->payload[$key] = $postalCode;
    }

    /**
     * @param $postalCode
     * @return bool
     */
    public function isValidPostalCode($postalCode): bool
    {
        return Location::isPostalCode($postalCode['postal_code']);
    }

    /**
     * @param $products
     */
    public function addProducts($products)
    {
        $products = is_array($products) ? $products : func_get_args();

        foreach ($products as $product) {
            $this->addProduct((array) $product, false);
        }
    }

    /**
     * @param $product
     * @param bool $returnPayload
     * @return object|void
     */
    public function addProduct($product, $returnPayload = true)
    {
        if (! is_array($product)) {
            throw new InvalidVolumeException('product');
        }
        if ($returnPayload){
            return (object) $product;
        } else {
            $this->payload['products'][] = $product;
        }
    }

    /**
     * @param $volumes
     */
    public function addVolumes($volumes)
    {
        $volumes = is_array($volumes) ? $volumes : func_get_args();

        foreach ($volumes as $volume) {
            $this->addVolume((array) $volume, false);
        }
    }

    /**
     * @param $volume
     * @param bool $returnPayload
     * @return object|void
     */
    public function addVolume($volume, $returnPayload = true)
    {
        if (! is_array((new VolumeCart($volume["height"], $volume["width"], $volume["length"], $volume["weight"]))->toArray() )) {
            throw new InvalidVolumeException('volume');
        }
        if ($returnPayload){
            return (object) $volume;
        } else {
            $this->payload['volumes'][] = $volume;
        }
    }

    /**
     * @param int $insuranceValue
     */
    public function setInsuranceValue($insuranceValue = 1)
    {
        if (! Number::isPositive($insuranceValue)) {
            throw new InvalidArgumentException('insurance_value');
        }

        $this->payload['options']["insurance_value"] = $insuranceValue;
    }

    /**
     * @param false $receipt
     */
    public function setReceipt($receipt = false)
    {
        if (! is_bool($receipt)) {
            throw new InvalidArgumentException('receipt');
        }

        $this->payload['options']['receipt'] = $receipt;
    }

    /**
     * @param false $ownHand
     */
    public function setOwnHand($ownHand = false)
    {
        if (! is_bool($ownHand)) {
            throw new InvalidArgumentException('own_hand');
        }

        $this->payload['options']['own_hand'] = $ownHand;
    }

    /**
     * @param false $reverse
     */
    public function setReverse($reverse = false)
    {
        if (! is_bool($reverse)) {
            throw new InvalidArgumentException('reverse');
        }

        $this->payload['options']['reverse'] = $reverse;
    }

    /**
     * @param false $nonCommercial
     */
    public function setNonCommercial($nonCommercial = false)
    {
        if (! is_bool($nonCommercial)) {
            throw new InvalidArgumentException('non-commercial');
        }

        $this->payload['options']['non_commercial'] = $nonCommercial;
    }

    /**
     * @param $invoice
     */
    public function setInvoice($invoice)
    {
        if (empty($invoice)){
            throw new InvalidArgumentException('invoice');
        }
        $this->payload['options']['invoice']['key'] = $invoice;
    }

    /**
     * @param $platform
     */
    public function setPlatform($platform)
    {
        if (empty($platform)){
            throw new InvalidArgumentException('platform');
        }
        $this->payload['options']['platform'] = $platform;
    }

    /**
     * @param $tag
     * @param null $url
     */
    public function addTag($tag, $url = null)
    {
        if (empty($tag)) {
            throw new InvalidVolumeException('tags');
        }

        $this->payload['tags'][] = ["tag" => $tag, "url" => $url];
    }

    /**
     * @throws InvalidCalculatorPayloadException
     */
    protected function validatePayload()
    {
        if (empty($this->payload['from']['postal_code']) || empty($this->payload['to']['postal_code'])) {
            throw new InvalidCalculatorPayloadException('The CEP is invalid. pleass verify your CEP');
        }

        if (empty($this->payload['volumes']) && empty($this->payload['products'])) {
            throw new InvalidCalculatorPayloadException('There are no defined products or volumes.');
        }
    }

    /**
     * @throws CalculatorException
     */
    public function find($page = ""): Cart
    {
        $this->activeRegister = $this->getCart(false, $page);
        return $this;
    }

    /**
     * @throws CalculatorException
     */
    public function findById($id): Cart
    {
        $this->activeRegister = $this->getCart($id);
        return $this;
    }

    /**
     * @param false $all
     * @return mixed
     */
    public function fetch(bool $all = false)
    {
        if ($all)
            return $this->activeRegister;
        else
            return ($this->activeRegister)['data'][0] ?? $this->activeRegister;
    }

    /**
     * @return bool
     * @throws CalculatorException
     */
    public function destroy(): bool
    {
        if (!$this->activeRegister['id']){
            throw new CalculatorException("Você precisa selecionar um item do carrinho válido");
        }
        return $this->deleteCart($this->activeRegister['id']);

    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @throws CalculatorException
     * @throws InvalidCalculatorPayloadException
     */
    public function sendCart()
    {
        $this->validatePayload();

        try {
            $response = $this->resource->getHttp()->post('me/cart', [
                'json' => $this->payload,
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (ClientException $exception) {
            throw new CalculatorException($exception);
        }
    }

    /**
     * @param string $id
     * @return mixed
     * @throws CalculatorException
     */
    protected function getCart($id = false, $page = "")
    {

        if ($id){
            $id = "/{$id}";
        }
        if (!empty($page)){
            $page = "?page={$page}";
        }

        try{
            $response = $this->resource->getHttp()->get("me/cart{$id}{$page}");
            return json_decode((string) $response->getBody(), true);
        } catch (ClientException $exception) {
            throw new CalculatorException($exception);
        }

    }

    /**
     * @param $id
     * @return bool
     * @throws CalculatorException
     */
    protected function deleteCart($id): bool
    {
        try {
            $response = $this->resource->getHttp()->delete("me/cart/{$id}");
            return true;
        } catch (ClientException $exception) {
            throw new CalculatorException($exception);
        }
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return json_encode($this->getPayload());
    }

}