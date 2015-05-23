<?php

namespace Com\Martiadrogue\Provincies\Model;

use InvalidArgumentException;

class Municipi
{

    private $index;
    private $name;
    private $code;
    private $controlDigit;

    public function __construct($index, $name, $code, $controlDigit)
    {
        $this->setIndex($index);
        $this->setName($name);
        $this->setCode($code);
        $this->setControlDigit($controlDigit);
    }

    private function setIndex($index)
    {
        if (strlen($index) > 6) {
            throw new InvalidArgumentException('The property $index cannot have a length biggest than 6 chars.');
        }

        $this->index = $index;
    }

    private function setName($name)
    {
        if (strlen($name) > 100) {
            throw new InvalidArgumentException('The property $name cannot have a length biggest than 100 chars.');
        }

        $this->name = $name;
    }

    private function setCode($number)
    {
        if (strlen($number) > 11) {
            throw new InvalidArgumentException('The property $code cannot have a length biggest than 11 chars.');
        }

        $this->code = $number;
    }

    private function setControlDigit($number)
    {
        if (strlen($number) > 11) {
            throw new InvalidArgumentException('The property $controlDigit cannot have a length biggest than 11 chars.');
        }

        $this->controlDigit = $number;
    }

    public function __toString()
    {
        return $this->name;
    }
}
