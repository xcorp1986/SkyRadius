<?php

declare(strict_types=1);


namespace SkyDiablo\SkyRadius\AttributeHandler;

use SkyDiablo\SkyRadius\Attribute\AttributeInterface;
use SkyDiablo\SkyRadius\Attribute\RawAttribute;
use SkyDiablo\SkyRadius\Attribute\TunnelAttribute;
use SkyDiablo\SkyRadius\Packet\RequestPacket;

class Tunnel3ByteValueAttributeHandler extends AbstractAttributeHandler
{

    /**
     * @inheritDoc
     */
    public function deserializeRawAttribute(RawAttribute $rawAttribute, RequestPacket $requestPacket)
    {
        return new TunnelAttribute($rawAttribute->getType(), $this->unpackInt8($rawAttribute->getValue()), substr($rawAttribute->getValue(), 1, 3));
    }

    /**
     * @inheritDoc
     */
    public function serializeValue(AttributeInterface $attribute, RequestPacket $requestPacket)
    {
        /** @var TunnelAttribute $attribute */
        return $this->packInt8($attribute->getTag()) . substr($attribute->getValue(), 0, 3);
    }
}