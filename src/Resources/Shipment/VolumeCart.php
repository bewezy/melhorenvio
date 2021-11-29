<?php

namespace MelhorEnvio\Resources\Shipment;

class VolumeCart extends Volume
{

    public function __construct($height, $width, $length, $weight)
    {
        $this->setHeight($height);
        $this->setWidth($width);
        $this->setLength($length);
        $this->setWeight($weight);
    }

    public function toArray(): array
    {
        return [
            'height' => $this->getHeight(),
            'width' => $this->getWidth(),
            'length' => $this->getLength(),
            'weight' => $this->getWeight(),
        ];
    }
}