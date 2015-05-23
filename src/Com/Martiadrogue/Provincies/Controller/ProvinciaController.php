<?php

namespace Com\Martiadrogue\Provincies\Controller;

use PDOException;

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
            $data['provincia'] = $pdo->readByUniqueField('provincias', 'id_provincia', $index, 'id_provincia', 'provincia');
            $data['municipis'] = $pdo->join('municipios', 'provincias', 'id_provincia', $index, 'cod_municipio', 'DC', 'nombre');

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
