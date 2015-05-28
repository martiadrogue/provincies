<?php

namespace Com\Martiadrogue\Provincies\Controller\Admin;

use Com\Martiadrogue\Mpwarfwk\Controller\BaseController;

class ProvinciaController extends AdminController
{
    public function executeIndex()
    {
        $data = parent::getMenuLinks();
        if (!parent::checkSession()) {
            header('Location: '.$data['links']['usuaris'].'/login');

            return '';
        }
        $data['userName'] = parent::getUserNameFromSession();
        try {
            $pdo = parent::getService('pdo');
            $data['provincies'] = $pdo->read('provincias', 'id_provincia', 'provincia');

            return parent::render('provincia/index.html', $data);
        } catch (PDOException $ex) {
            if ($ex->getCode() === '42S02') {
                // crea taula
            }
        }
        echo "Everithing goes wrong!";
    }

    public function executeCreate()
    {
        $data = parent::getMenuLinks();
        if (!parent::checkSession()) {
            header('Location: '.$data['links']['usuaris'].'/login');

            return '';
        }
        $data['userName'] = parent::getUserNameFromSession();
        $data['links']['action'] = $data['links']['provincies'].'/create';
        try {
            $pdo = parent::getService('pdo');
            $request = parent::getService('request');
            $idProvincia = $request->getPost('id_provincia');
            if ($idProvincia) {
                $this->createProvincia($idProvincia, $request, $pdo);
                header('Location: '.$data['links']['provincies']);

                return '';
            }

            return parent::render('provincia/create.html', $data);
        } catch (PDOException $ex) {
            if ($ex->getCode() === '42S02') {
                // crea taula
            }
        }

        echo "Everithing goes wrong!";
    }

    public function executeEdit($index)
    {
        $data = parent::getMenuLinks();
        if (!parent::checkSession()) {
            header('Location: '.$data['links']['usuaris'].'/login');

            return '';
        }
        $data['userName'] = parent::getUserNameFromSession();
        $data['links']['action'] = $data['links']['provincies'].'/edit/'.$index;
        try {
            $pdo = parent::getService('pdo');
            $request = parent::getService('request');
            $idProvincia = $request->getPost('id_provincia');
            if ($idProvincia) {
                $this->editProvincia($idProvincia, $request, $pdo);
                header('Location: '.$data['links']['provincies']);

                return '';
            }
            $data['provincia'] = $this->getProvincia($index, $pdo);

            return parent::render('provincia/edit.html', $data);
        } catch (PDOException $ex) {
            if ($ex->getCode() === '42S02') {
                // crea taula
            }
        }

        echo "Everithing goes wrong!";
    }

    public function executeDelete($index)
    {
        $data = parent::getMenuLinks();
        $data['links']['action'] = $data['links']['provincies'].'/delete/'.$index;
        try {
            $pdo = parent::getService('pdo');
            if ($index) {
                $pdo->delete('provincias', 'id_provincia', $index);
                $this->removeCache($index);
                header('Location: '.$data['links']['provincies']);

                return '';
            }
        } catch (PDOException $ex) {
            if ($ex->getCode() === '42S02') {
                // crea taula
            }
        }
        echo "Everithing goes wrong!";
    }

    private function createProvincia($idProvincia, $request, $pdo)
    {
        $provincia = $request->getPost('provincia');
        $pdo->query("INSERT INTO provincias VALUES ($idProvincia, '$provincia')");
        $this->removeCache($idProvincia);
    }

    private function editProvincia($idProvincia, $request, $pdo)
    {
        $nombre = $request->getPost('provincia');
        $pdo->update('provincias', 'id_provincia', $idProvincia, 'id_provincia', $idProvincia, 'provincia', $nombre);
        $this->removeCache($idProvincia);

    }

    private function getProvincia($idProvincia,  $pdo)
    {
        return $pdo->readByUniqueField('provincias',' id_provincia', $idProvincia, 'id_provincia', 'provincia');
    }

    private function removeCache($index)
    {
        parent::deleteModelCache('provincia');
        parent::deleteModelCache('provincia'.$index);
    }

}
