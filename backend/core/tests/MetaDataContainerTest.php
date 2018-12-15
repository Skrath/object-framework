<?php

namespace CoreTests;

use PHPUnit\Framework\TestCase;

use Core\DataContainer;
use Core\MetaDataContainer;
use Core\Datum;

final class MetaDataContainerTest extends TestCase {
    private $testDataList = ['Apple', 'Banana', 'Turnip'];

    private $testDataSimple = [
        'Name' => "John",
    ];

    public function testCanBeCreatedFromNothing(): Void
    {
        $dataContainer = new MetaDataContainer();

        $this->assertInstanceOf(
            MetaDataContainer::class,
            $dataContainer
        );
    }
}