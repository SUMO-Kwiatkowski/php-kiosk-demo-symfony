<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Tests\Unit\Service\Invoice\Create;

use App\Service\Invoice\Create\PosParamsValidator;
use App\Configuration\BitPayConfiguration;
use App\Configuration\Design;
use App\Configuration\Donation;
use App\Configuration\Field;
use App\Configuration\Hero;
use App\Configuration\Mode;
use App\Configuration\PosData;
use App\Exception\ValidationFailed;
use PHPUnit\Framework\TestCase;

class PosParamsValidatorTest extends TestCase
{
    /**
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function it_should_throws_exception_for_missing_value_for_required_field()
    {
        $this->expectException(ValidationFailed::class);

        $posData = new PosData();
        $posData->setFields([]);
        $testedClass = $this->getTestedClass($posData);
        $params = [
            'store' => 'store-1',
            'register' => '2',
            'reg_transaction_no' => 'test123'
        ];
        $testedClass->execute($params);
    }

    /**
     * @test
     */
    public function it_should_throws_exception_for_missing_price(): void
    {
        $priceField = new Field();
        $priceField->setType('price');
        $priceField->setRequired(true);
        $priceField->setName('price');
        $posData = new PosData();
        $posData->setFields([$priceField]);

        $this->expectException(ValidationFailed::class);

        $testedClass = $this->getTestedClass($posData);
        $params = [
            'store' => 'store-1',
            'register' => '2',
            'reg_transaction_no' => 'test123'
        ];
        $testedClass->execute($params);
    }

    /**
     * @test
     */
    public function it_should_returns_validated_params_without_unnecessary(): void
    {
        $priceField = new Field();
        $priceField->setType('price');
        $priceField->setRequired(true);
        $priceField->setName('price');
        $storeField = new Field();
        $storeField->setType('store');
        $storeField->setRequired(false);
        $storeField->setName('store');
        $posData = new PosData();
        $posData->setFields([$priceField, $storeField]);

        $testedClass = $this->getTestedClass($posData);
        $params = [
            'store' => 'store-1',
            'register' => '2',
            'reg_transaction_no' => 'test123',
            'price' => '12.34',
            'buyerName' => 'Test',
            'buyerAddress1' => 'SomeTestAddress',
            'buyerAddress2' => null,
            'buyerLocality' => 'SomeCity',
            'buyerRegion' => 'AK',
            'buyerPostalCode' => '12345',
            'buyerPhone' => '997',
            'buyerEmail' => 'some@email.com',
        ];
        $result = $testedClass->execute($params);

        self::assertEquals(
            [
                'store' => 'store-1',
                'price' => '12.34'
            ],
            $result
        );
    }

    /**
     * @return PosParamsValidator
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    private function getTestedClass(PosData $posData): PosParamsValidator
    {
        $hero = $this->createStub(Hero::class);
        $design = new Design($hero, 'someLogo', $posData);
        $donation = $this->createMock(Donation::class);
        $bitPayConfiguration = new BitPayConfiguration(
            'pos',
            'test',
            $design,
            $donation,
            Mode::STANDARD,
            'someToken',
            'someNotification@email.com'
        );
        return new PosParamsValidator($bitPayConfiguration);
    }
}
