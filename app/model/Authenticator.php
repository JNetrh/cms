<?php

namespace App\Model;

use Nette;
use Nette\Security as NS;

class Authenticator implements NS\IAuthenticator
{

    /** @var Nette\Database\Table\Selection */
    private $database;


    function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    function authenticate(array $credentials)
    {
        list($email, $password) = $credentials;
        $row = $this->database->table('users')
        ->where('email', $email)->fetch();

        if (!$row) {
            throw new NS\AuthenticationException('Špatný email.');
        }

        if (!NS\Passwords::verify($password, $row->password)) {
            throw new NS\AuthenticationException('Špatné heslo.');
        }


        $rights = [];
        foreach ($this->database->table('userrights')->where('userId', $row->id) as $rightId){
            $rights[] = $rightId->ref('rights', 'rightId')->name;
        }



        return new NS\Identity($row->id, $rights, ['email' => $row->email]);
    }


}