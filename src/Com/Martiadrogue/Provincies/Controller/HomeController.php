<?php

namespace Com\Martiadrogue\Provincies\Controller;

use PDOException;

/**
 *
 */
class HomeController extends ProvinciesController
{
    public function __construct()
    {
        # code...
    }

    public function executeIndex()
    {
        $data = parent::getMenuLinks();
        try {
            $data['provincias'] = $this->getModelCache('provincia');
            if (!$data['provincias']) {
                $pdo = parent::getService('pdo');
                $data['provincias'] = $pdo->read('provincias', 'id_provincia', 'provincia');
                $this->addModelCache('provincia', $data['provincias']);
            }

            return parent::render('home/index.html', $data);
        } catch (PDOException $ex) {
            if ($ex->getCode() === '42S02') {
                // crea taula
            }
        }

        return parent::render('home/index.html', []);
    }

    public function executeAbout()
    {
        $data = parent::getMenuLinks();
        $data['title'] = 'About Framework MVC';
        $data['message'] = 'Hello from '.__METHOD__;

        return parent::render('home/about.html', $data);
    }

    public function executeContact()
    {
        $data = parent::getMenuLinks();
        $data['title'] = 'Get In Touch!';
        $data['message'] = 'Hello from '.__METHOD__;

        return parent::render('home/contact.html', $data);
    }
}
