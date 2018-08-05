<?php

namespace CoreTests;

use PHPUnit\Framework\TestCase;

use Core\DataContainer;
use Core\Datum;

final class DataContainerTest extends TestCase {
    private $testDataList = ['Apple', 'Banana', 'Turnip'];

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

    public function testCanBeCreatedFromList(): Void
    {
        $dataContainer = new DataContainer($this->testDataList);

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

    public function testCanGetObjectByMethodCall(): Void {
        $dataContainer = new DataContainer($this->testDataSimple);

        $this->assertInstanceOf(
            Datum::class,
            $dataContainer->Name()
        );
        $this->assertEquals('John', $dataContainer->Name()());
    }

    public function testCanGetValueByDirectAccess(): Void
    {
        $dataContainer = new DataContainer($this->testDataComplex);

        $this->assertEquals('Steve', $dataContainer->Name);
    }

    public function testWillReturnNullOnUnknownValue(): Void
    {
        $dataContainer = new DataContainer($this->testDataSimple);

        $this->assertNull($dataContainer->BogusValue);
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

    public function testCanBeIteratedUpon(): Void
    {
        $dataContainer = new DataContainer($this->testDataList);
        $resultArray = [];
        foreach ($dataContainer as $value) {
            $resultArray[] = $value;
        }
        $this->assertEquals($this->testDataList, $resultArray);

        $dataContainer = new DataContainer($this->testDataSimple);
        $resultArray = [];
        foreach ($dataContainer as $key => $value) {
            $resultArray[$key] = $value;
        }
        $this->assertEquals($this->testDataSimple, $resultArray);
    }

    public function testCanBeAccessedAsArray(): Void
    {
        $dataContainer = new DataContainer($this->testDataList);
        $this->assertEquals('Banana', $dataContainer[1]);
        $dataContainer[1] = 'Bandana';
        $this->assertEquals('Bandana', $dataContainer[1]);

        $dataContainer = new DataContainer($this->testDataSimple);
        $this->assertEquals('John', $dataContainer['Name']);
        $dataContainer['Name'] = 'Steve';
        $this->assertEquals('Steve', $dataContainer['Name']);
    }
}