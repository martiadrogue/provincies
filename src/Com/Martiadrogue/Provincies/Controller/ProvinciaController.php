<?php

namespace Com\Martiadrogue\Provincies\Controller;

use PDOException;
use Com\Martiadrogue\Provincies\Common\ProvinciaConverter;

/**
 *
 */
class ProvinciaController extends ProvinciesController
{
    public function __construct()
    {
        # code...
    }

    public function executeIndex()
    {
        $data = parent::getMenuLinks();

        return parent::render('provincia/index.html', $data);
    }

    public function executeDetail($index)
    {
        $data = parent::getMenuLinks();
        try {
            $pdo = parent::getService('pdo');
            $code = substr($index, 0, 2);
            $fields = $pdo->joinByField('municipios', 'provincias', 'id_provincia', $code, 'id_municipio', 'id_provincia', 'provincia', 'cod_municipio', 'DC', 'nombre');
            $converter = new ProvinciaConverter($fields);
            $data['provincia'] = $converter->convert();

            return parent::render('provincia/detail.html', $data);
        } catch (PDOException $ex) {
            if ($ex->getCode() === '42S02') {
                // crea taula
            }
            return parent::render('503.html', []);
        }

        return parent::render('404.html', []);
    }
}
