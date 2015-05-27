<?php

namespace Com\Martiadrogue\Provincies\Controller\Admin;

use Com\Martiadrogue\Mpwarfwk\Controller\BaseController;

class MunicipiController extends AdminController
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
            $data['municipis'] = $this->getMunicipis();

            return parent::render('municipi/index.html', $data);
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
        $data['links']['action'] = $data['links']['municipis'].'/create';
        try {
            $pdo = parent::getService('pdo');
            $request = parent::getService('request');
            $codMunicipi = $request->getPost('cod_municipio');
            if ($codMunicipi) {
                $this->createMunicipi($codMunicipi, $request, $pdo);
                header('Location: '.$data['links']['municipis']);

                return '';
            }
            $data['provincies'] = $this->getProvincies($pdo);

            return parent::render('municipi/create.html', $data);
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
        $data['links']['action'] = $data['links']['municipis'].'/edit/'.$index;
        try {
            $pdo = parent::getService('pdo');
            $request = parent::getService('request');
            $idMunicipio = $request->getPost('id_municipio');
            if ($idMunicipio) {
                $this->editMunicipi($idMunicipio, $request, $pdo);
                header('Location: '.$data['links']['municipis']);

                return '';
            }
            $output = $this->getProvinciesAndMunicipi($pdo, $index);
            $data = array_merge($data, $output);

            return parent::render('municipi/edit.html', $data);
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
        $data['links']['action'] = $data['links']['municipis'].'/delete/'.$index;
        try {
            $pdo = parent::getService('pdo');
            if ($index) {
                $pdo->delete('municipios', 'id_municipio', $index);
                header('Location: '.$data['links']['municipis']);

                return '';
            }
        } catch (PDOException $ex) {
            if ($ex->getCode() === '42S02') {
                // crea taula
            }
        }
        echo "Everithing goes wrong!";
    }

    private function getMunicipis()
    {
        $pdo = parent::getService('pdo');

        return $pdo->join('municipios', 'provincias', 'id_provincia', 'id_municipio', 'cod_municipio', 'DC', 'nombre', 'provincia');
    }

    private function createMunicipi($codMunicipi, $request, $pdo)
    {
        $idProvincia = $request->getPost('id_provincia');
        $digitControl = $request->getPost('dc');
        $nom = $request->getPost('nombre');
        $pdo->create('municipios', $idProvincia, $codMunicipi, $digitControl, $nom);
    }

    private function editMunicipi($idMunicipio, $request, $pdo)
    {
        $codMunicipi = $request->getPost('cod_municipio');
        $idProvincia = $request->getPost('id_provincia');
        $digitControl = $request->getPost('dc');
        $nom = $request->getPost('nombre');
        $pdo->update(
                'municipios', 'id_municipio', $idMunicipio,
                'id_municipio', $idMunicipio,
                'id_provincia', $idProvincia,
                'cod_municipio', $codMunicipi,
                'DC', $digitControl,
                'nombre', $nom
            );
    }

    private function getProvincies($pdo)
    {
        return $pdo->read('provincias', 'id_provincia', 'provincia');
    }

    private function getProvinciesAndMunicipi($pdo, $index)
    {
        $fields = $pdo->select('SELECT id_municipio, cod_municipio, DC, nombre, id_provincia, null as provincia FROM municipios WHERE id_municipio = '.$index.' UNION SELECT null, null, null, null, id_provincia, provincia FROM provincias');
        $data['municipi'] = array_shift($fields);
        $data['provincies'] = $fields;

        return $data;
    }


}