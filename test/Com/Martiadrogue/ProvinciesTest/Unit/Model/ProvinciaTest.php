<?php

namespace Com\Martiadrogue\ProvinciesTest\Model;

use Com\Martiadrogue\Provincies\Model\Provincia;

class ProvinciaTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function shouldSaveIndexesWithLessCharsThan6()
    {
        $this->setExpectedException(
                'InvalidArgumentException',
                'The property $index cannot have a length biggest than 6 chars.'
            );
        new Provincia(1234567, '', []);
    }

    /** @test */
    public function shouldSaveNamesWithLessCharsThan30()
    {
        $this->setExpectedException(
                'InvalidArgumentException',
                'The property $name cannot have a length biggest than 30 chars.'
            );
        new Provincia(1, 'ZJXnXyQFdb3ZBWOIGfRXvTBhFk6eMHR', []);
    }

    /** @test */
    public function shouldToStringMethodReturnsTheNameParameter()
    {
        $provincia = new Provincia(1, 'Barcelona', []);
        $this->assertSame($provincia->__toString(), 'Barcelona', 'Constructor of Provincia has \'Barcelona\' as name property, so the method Provincia::__toString(); needs to return the same value.');
    }
}
