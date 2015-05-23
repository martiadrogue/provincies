<?php

namespace Com\Martiadrogue\Provincies\Common;

use Com\Martiadrogue\Provincies\Model\Municipi;
use Com\Martiadrogue\Provincies\Model\Provincia;

class ProvinciaConverter
{
    private $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function convert()
    {
        $index = $this->fields[0]['id_provincia'];
        $name = $this->fields[0]['provincia'];
        $municipis = [];
        foreach ($this->fields as $value) {
            $municipis[] = new Municipi($value['id_municipio'], $value['nombre'], $value['cod_municipio'], $value['DC']);
        }

        return new Provincia($index, $name, $municipis);
    }
}
