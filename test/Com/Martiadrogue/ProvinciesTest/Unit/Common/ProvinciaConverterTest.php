<?php

namespace Com\Martiadrogue\ProvinciesTest\Common;

use Com\Martiadrogue\Provincies\Model\Provincia;
use Com\Martiadrogue\Provincies\Common\ProvinciaConverter;

class ProvinciaConverterTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function shouldReturnAProvinciaObject()
    {
        $converter = new ProvinciaConverter([]);
        $expected = $converter->convert();
        $this->assertInstanceOf(Provincia::class, $expected, 'Always returns an instance of ProvinciaConverter.');
    }
}
