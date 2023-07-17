<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Configuration;

interface BitPayConfigurationInterface
{
    /**
     * @return Design
     */
    public function getDesign(): Design;

    /**
     * @return string|null
     */
    public function getToken(): string;

    public function getDonation(): Donation;

    /**
     * @return string|null
     */
    public function getNotificationEmail(): ?string;

    public function getEnvironment(): string;

    public function getCurrencyIsoCode(): string;

    public function getFacade(): string;

    public function isSignRequest(): bool;

    public function getMode(): Mode;

    public function setMode(Mode $mode);
}
