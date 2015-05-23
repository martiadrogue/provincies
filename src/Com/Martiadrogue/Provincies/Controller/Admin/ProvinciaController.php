<?php

namespace Com\Martiadrogue\Provincies\Controller\Admin;

use Com\Martiadrogue\Provincies\Controller\ProvinciesController;
/**
 *
 */
class ProvinciaController extends ProvinciesController
{
    public function executeIndex()
    {
        $data = parent::getMenuLinks();
        try {
            $pdo = parent::getService('pdo');
            $data['provincias'] = $pdo->read('provincias', 'id_provincia', 'provincia');

            return parent::render('admin/provincia/index.html', $data);
        } catch (PDOException $ex) {
            if ($ex->getCode() === '42S02') {
                // crea taula
            }
        }

        return parent::render('home/index.html', []);
    }
}
