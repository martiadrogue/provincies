<?php

namespace Com\Martiadrogue\Provincies\Model;

use InvalidArgumentException;

class Provincia
{

    private $index;
    private $name;
    private $municipis;

    public function __construct($index, $name, array $municipis)
    {
        $this->setIndex($index);
        $this->setName($name);
        $this->municipis = $municipis;
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
        if (strlen($name) > 30) {
            throw new InvalidArgumentException('The property $name cannot have a length biggest than 30 chars.');
        }

        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMunicipis()
    {
        return $this->municipis;
    }

    public function __toString()
    {
        return $this->name;
    }
}
