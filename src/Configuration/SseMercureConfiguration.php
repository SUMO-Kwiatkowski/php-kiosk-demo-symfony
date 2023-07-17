<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Configuration;

use Symfony\Component\Mercure\HubInterface;

class SseMercureConfiguration implements SseConfiguration
{
    private HubInterface $hub;

    public function __construct(HubInterface $hub)
    {
        $this->hub = $hub;
    }

    public function internalUrl(): string
    {
        return $this->hub->getUrl();
    }

    public function publicUrl(): string
    {
        return $this->hub->getPublicUrl();
    }
}
