<?php

namespace Com\Martiadrogue\Provincies\Controller;

use Com\Martiadrogue\Mpwarfwk\Controller\BaseController;
use Com\Martiadrogue\Mpwarfwk\Connection\Http\JsonResponse;

class MunicipiService extends ProvinciesService
{
    public function __construct()
    {
        # code...
    }

    public function executeIndex($index)
    {
        try {
            $pdo = parent::getService('pdo');
            $data['municipis'] = $pdo->readByField('municipios', 'id_provincia', $index, 'id_municipio', 'id_provincia', 'nombre');

        } catch (PDOException $ex) {
            $data['municipis'] = [];
            if ($ex->getCode() === '42S02') {
                // crea taula
            }
        }
        return parent::encode($data);

    }
}
