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

    public function executeIndex($string)
    {
        $sphinx = parent::getService('sphinx');
        $data = $sphinx->addQuery($string, 'municipios');

        return parent::encode($data);

    }
}
