<?php

namespace Com\Martiadrogue\ProvinciesTest\Model;

use Com\Martiadrogue\Provincies\Model\Municipi;

class MunicipiTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function shouldSaveIndexesWithLessCharsThan6()
    {
        $this->setExpectedException(
                'InvalidArgumentException',
                'The property $index cannot have a length biggest than 6 chars.'
            );
        new Municipi(1234567, '', 1, 1);
    }

    /** @test */
    public function shouldSaveNamesWithLessCharsThan100()
    {
        $this->setExpectedException(
                'InvalidArgumentException',
                'The property $name cannot have a length biggest than 100 chars.'
            );
        new Municipi(1, '2cGt5StP5aQuixyt4mb9J0LqL3kD5gaulA9udZU3tz6VgAHUAVsunsMFOj3WVjhNVzk2rg4bN0ZTVxVY1gkFaCmHAwNwneWOEbP0Q', 1, 1);
    }

    /** @test */
    public function shouldSaveCodesWithLessCharsThan11()
    {
        $this->setExpectedException(
                'InvalidArgumentException',
                'The property $code cannot have a length biggest than 11 chars.'
            );
        new Municipi(1, '', 123456789012, 1);
    }

    /** @test */
    public function shouldSaveControlDigitsWithLessCharsThan11()
    {
        $this->setExpectedException(
                'InvalidArgumentException',
                'The property $controlDigit cannot have a length biggest than 11 chars.'
            );
        new Municipi(1, '', 1, 123456789012);
    }

    /** @test */
    public function shouldToStringMethodReturnsTheNameParameter()
    {
        $municipi = new Municipi(1, 'Bagà', 1, 1);
        $this->assertSame($municipi->__toString(), 'Bagà', 'Constructor of Provincia has \'Bagà\' as name property, so the method Provincia::__toString(); needs to return the same value.');
    }
}
