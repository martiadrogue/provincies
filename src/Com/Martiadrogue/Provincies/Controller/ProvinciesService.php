<?php

namespace Com\Martiadrogue\Provincies\Controller;

use Com\Martiadrogue\Mpwarfwk\Controller\BaseController;
use Com\Martiadrogue\Mpwarfwk\Connection\Http\JsonResponse;

class ProvinciesService extends BaseController
{
    public function __construct()
    {
        # code...
    }

    protected function encode(Array $data)
    {
        $encode = json_encode($data);

        return new JsonResponse($encode, 200);
    }
}
