<?php

namespace CoreTests;

use PHPUnit\Framework\TestCase;

use Core\DataContainer;
use Core\Datum;

final class DatumTest extends TestCase {

    public function testCanBeCreatedFromString(): void
    {
        $datum = new Datum('test');

        $this->assertInstanceOf(Datum::class, $datum);
        $this->assertEquals('test', $datum());
    }

    public function testCanBeCreatedFromInt(): void
    {
        $datum = new Datum(42);

        $this->assertInstanceOf(Datum::class, $datum);
        $this->assertEquals(42, $datum());
    }

    public function testCanBeCreatedFromBool(): void
    {
        $datum = new Datum(true);

        $this->assertInstanceOf(Datum::class, $datum);
        $this->assertTrue($datum());
    }

    public function testCanBeCreatedFromFloat(): void
    {
        $datum = new Datum(3.14159);

        $this->assertInstanceOf(Datum::class, $datum);
        $this->assertEquals(3.14159, $datum());
    }

    public function testCanBeCreatedFromArray(): void
    {
        $datum = new Datum([
            'thing1' => 'value1',
            'thing2' => 'value2'
        ]);

        $this->assertInstanceOf(Datum::class, $datum);
        $this->assertInstanceOf(DataContainer::class, $datum());
        $this->assertEquals('value1', $datum()->thing1);
    }

    public function testCanBeSetWithNewValue(): void
    {
        $datum = new Datum();

        $datum('Steve');

        $this->assertEquals('Steve', $datum());
    }

    public function testCanGetType(): void
    {
        $datum = new Datum('Steve');

        $this->assertEquals('string', $datum->getType());
    }

    public function testCanChangeType(): void
    {
        $datum = new Datum();

        $this->assertEquals('unknown', $datum->getType());

        $datum->setType('string');
        $this->assertEquals('string', $datum->getType());   
    }

    public function testCanAutomaticallySetType(): void
    {
        $datum = new Datum('Steve');
        $this->assertEquals('string', $datum->getType());
        $this->assertInternalType('string', $datum());

        $datum = new Datum(42);
        $this->assertEquals('integer', $datum->getType());
        $this->assertInternalType('integer', $datum());

        $datum = new Datum(3.14159);
        $this->assertEquals('double', $datum->getType());
        $this->assertInternalType('double', $datum());

        $datum = new Datum(true);
        $this->assertEquals('boolean', $datum->getType());
        $this->assertInternalType('boolean', $datum());
    }

    public function testCanAutomaticallyCastByType(): void {
        $datum = new Datum('Steve');
        $datum(42);
        $this->assertInternalType('string', $datum());
        $this->assertEquals('42', $datum());

        $datum = new Datum(42);
        $datum('75');
        $this->assertInternalType('integer', $datum());
        $this->assertEquals(75, $datum());

        $datum = new Datum(3.14159);
        $datum('3.14');
        $this->assertInternalType('double', $datum());
        $this->assertEquals(3.14, $datum());

        $datum = new Datum(true);
        $datum(0);
        $this->assertInternalType('boolean', $datum());
        $this->assertEquals(false, $datum());
    }
}