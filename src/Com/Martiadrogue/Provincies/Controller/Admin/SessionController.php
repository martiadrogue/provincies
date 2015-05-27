<?php

namespace Com\Martiadrogue\Provincies\Controller\Admin;

use Com\Martiadrogue\Mpwarfwk\Controller\BaseController;
use Com\Martiadrogue\Provincies\Common\SessionHandler;

class SessionController extends AdminController
{
    public function executeObtainAccess()
    {
        $data = parent::getMenuLinks();
        $data['links']['action'] = $data['links']['usuaris'].'/login';
        try {
            $pdo = parent::getService('pdo');
            $request = parent::getService('request');
            $name = $request->getPost('name');
            if ($name) {
                $password = $request->getPost('password');
                $data['usuari'] = $pdo->readByUniqueField('users', 'name', "'$name'", 'password');

                $sessionHandler = new SessionHandler($request->getSession(), $request->getClientAddresses());
                if ($sessionHandler->openSession($name, $password, $data['usuari']['password'])) {
                    header('Location: '.$data['links']['provincies']);

                    return '';
                }
            }

            return parent::render('login/index.html', $data);
        } catch (PDOException $ex) {
            if ($ex->getCode() === '42S02') {
                // crea taula
            }
        }
        echo "Everithing goes wrong!";
    }

    public function executeCloseAccess()
    {
        $data = parent::getMenuLinks();
        $request = parent::getService('request');

        $sessionHandler = new SessionHandler($request->getSession(), $request->getClientAddresses());
        $sessionHandler->closeSession();
        header('Location: '.$data['links']['usuaris'].'/login');

        return '';
        }
}
