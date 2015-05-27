<?php

namespace Com\Martiadrogue\Provincies\Controller\Admin;

use Com\Martiadrogue\Mpwarfwk\Controller\BaseController;
use Com\Martiadrogue\Provincies\Common\Bcrypter;

class UsuariController extends AdminController
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
            $data['usuaris'] = $pdo->read('users', 'id_user', 'name', 'email');

            return parent::render('user/index.html', $data);
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
        $data['links']['action'] = $data['links']['usuaris'].'/create';
        try {
            $pdo = parent::getService('pdo');
            $request = parent::getService('request');
            $email = $request->getPost('email');
            if ($email) {
                $this->createUsuari($request, $pdo);
                header('Location: '.$data['links']['usuaris']);

                return '';
            }

            return parent::render('user/create.html', $data);
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
        try {
            $pdo = parent::getService('pdo');
            if ($index) {
                $this->changePassword($index, $pdo);
                header('Location: '.$data['links']['usuaris']);

                return '';
            }
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
        $data['links']['action'] = $data['links']['usuaris'].'/delete/'.$index;
        try {
            $pdo = parent::getService('pdo');
            if ($index) {
                $pdo->delete('users', 'id_user', $index);
                header('Location: '.$data['links']['usuaris']);

                return '';
            }
        } catch (PDOException $ex) {
            if ($ex->getCode() === '42S02') {
                // crea taula
            }
        }
        echo "Everithing goes wrong!";
    }

    private function createUsuari($request, $pdo)
    {
        $nom = $request->getPost('name');
        $email = $request->getPost('email');
        $password = $this->randomPassword();
        $bcrypter = new Bcrypter();
        $hash = $bcrypter->hashPassoword($password);

        $pdo->create('users', $nom, $email, $hash);

        $this->sendMail($email, $password);
    }

    private function updateUsuari($pdo, $index, $name, $email, $hash)
    {
        $pdo->update('users', 'id_user', $index, 'name', $name, 'email', $email, 'password', $hash);
    }

    private function changePassword($index, $pdo)
    {
        $data = $pdo->readByUniqueField('users', 'id_user', $index, 'name', 'email');
        $password = $this->randomPassword();
        $bcrypter = new Bcrypter();
        $hash = $bcrypter->hashPassoword($password);
        $this->updateUsuari($pdo, $index, $data['name'], $data['email'], $hash);
        $this->sendMail($data['email'], $password);
    }

    public function sendMail($mailto, $password)
    {
        $subject = 'Provincies: Your Password';
        $message = "Welcome, your password is:<h1>$password</h1>";
        $headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: webmaster@example.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'Reply-To: webmaster@example.com' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
        mail($mailto, $subject, $message, $headers);
    }

    private function randomPassword() {
        $length = 6;
        $newPassword = '';
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $newPassword .= $characters[$rand];
        }
        return $newPassword;
    }
}
