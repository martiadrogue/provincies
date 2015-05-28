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
            $data['municipis'] = $this->getModelCache('municipi'.$index);
            if (!$data['municipis']) {
                $pdo = parent::getService('pdo');
                $data['municipis'] = $pdo->readByField('municipios', 'id_provincia', $index, 'id_municipio', 'id_provincia', 'nombre');
                $this->addModelCache('municipi'.$index, $data['municipis']);
            }
        } catch (PDOException $ex) {
            $data['municipis'] = [];
            if ($ex->getCode() === '42S02') {
                // crea taula
            }
        }
        return parent::encode($data);

    }
}
