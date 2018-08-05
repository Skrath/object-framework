<?php

namespace CoreTests;

use PHPUnit\Framework\TestCase;

use Core\DataContainer;
use Core\Datum;

final class DataContainerTest extends TestCase {
    private $testDataSimple = [
        'Name' => "John",
    ];

    private $testDataComplex = [
        'Name' => 'Steve',
        'Age' => 36,
        'Fraction' => 3.14159,
        'Alive' => true,
        'Address' => [
                'Street' => '123 Fake Street',
                'State' => 'Vermont'
            ]
        ];

    public function testCanBeCreatedFromNothing(): Void
    {
        $dataContainer = new DataContainer();

        $this->assertInstanceOf(
            DataContainer::class,
            $dataContainer
        );
    }

    public function testCanBeCreatedFromSimpleArray(): Void
    {
        $dataContainer = new DataContainer($this->testDataSimple);

        $this->assertInstanceOf(
            DataContainer::class,
            $dataContainer
        );
    }

    public function testCanBeCreatedFromComplexArray(): Void
    {
        $dataContainer = new DataContainer($this->testDataComplex);

        $this->assertInstanceOf(
            DataContainer::class,
            $dataContainer
        );
    }

    public function testCanGetValueByMethodCall(): Void
    {
        $dataContainer = new DataContainer($this->testDataComplex);

        $this->assertEquals('Steve', $dataContainer->getName());
    }

    public function testCanGetValueByDirectAccess(): Void
    {
        $dataContainer = new DataContainer($this->testDataComplex);

        $this->assertEquals('Steve', $dataContainer->Name);
    }

    public function testCanGetValueFromSubObject(): Void
    {
        $dataContainer = new DataContainer($this->testDataComplex);

        $this->assertEquals('Vermont', $dataContainer->Address->State);
        $this->assertEquals('Vermont', $dataContainer->getAddress()->getState());
    }

    public function testCanSetValueByMethodCall(): Void
    {
        $dataContainer = new DataContainer($this->testDataComplex);

        $dataContainer->setName('Doug');

        $this->assertEquals('Doug', $dataContainer->Name);
    }

    public function testCanSetValueByDirectAccess(): Void
    {
        $dataContainer = new DataContainer($this->testDataComplex);

        $dataContainer->Name = 'Doug';

        $this->assertEquals('Doug', $dataContainer->Name);
    }
}