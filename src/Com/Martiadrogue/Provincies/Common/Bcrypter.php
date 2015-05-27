<?php

namespace Com\Martiadrogue\Provincies\Common;

class Bcrypter
{

    public function __construct()
    {

    }

    public function hashPassoword($password)
    {
        $options = [
                'cost' => 11,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function verifyPassword($password, $hash)
    {
        if (password_verify($password, $hash)) {
             return true;
        }

        return false;
    }
}
