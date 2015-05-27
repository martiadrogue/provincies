<?php

namespace Com\Martiadrogue\Provincies\Common;

use Com\Martiadrogue\Mpwarfwk\Connection\Http\Session;
use Com\Martiadrogue\Provincies\Common\Bcrypter;

class SessionHandler
{
    private $session;
    private $ipClient;
    const SESSION_TAG = 'login';
    const USER_TAG = 'user';

    public function __construct(Session $session, $ipClient)
    {
        $this->session = $session;
        $this->ipClient = $ipClient;
    }

    public function openSession($userName, $password, $hash)
    {
        $bcrypter = new Bcrypter();
        if ($bcrypter->verifyPassword($password, $hash)) {
            $this->setSessionValue(self::SESSION_TAG, md5($userName.$this->ipClient));
            $this->setSessionValue(self::USER_TAG, $userName);

            return true;
        }

        return false;
    }

    public function closeSession()
    {
        setcookie (session_id(), '', time() - 3600);
        session_destroy();
        session_write_close();
    }

    public function checkSession()
    {
        $hash = md5($this->getSessionData(self::USER_TAG).$this->ipClient);

        return $hash === $this->getSessionData(self::SESSION_TAG);
    }

    public function setSessionValue($key, $value)
    {
        $this->session->setValue($key, $value);
    }

    public function getSessionData($key)
    {
        return $this->session->getData($key);
    }



}
