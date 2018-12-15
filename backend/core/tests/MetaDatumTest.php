<?php

namespace CoreTests;

use PHPUnit\Framework\TestCase;

use Core\MetaDataContainer;
use Core\MetaDatum;

final class MetaDatumTest extends TestCase {

    public function testCanBeCreatedFromNothing(): void
    {
        $datum = new MetaDatum();

        $this->assertInstanceOf(MetaDatum::class, $datum);

        $this->assertNull($datum->meta());
    }
}