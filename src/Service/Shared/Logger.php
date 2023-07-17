<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Service\Shared;

interface Logger
{
    public function info(string $code, string $message, array $context): void;

    public function error(string $code, string $message, array $context): void;
}
