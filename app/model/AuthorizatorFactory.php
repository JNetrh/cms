<?php

namespace App\Model;

use Nette\Security\Permission;
use App\Model\Authenticator;

class AuthorizatorFactory {

    /**
    * @return \Nette\Security\IAuthorizator
    */
    public function create() {
        $permission = new Permission();

        /* seznam uživatelských rolí */
        $permission->addRole('admin');
        $permission->addRole('header');
        $permission->addRole('members');
        $permission->addRole('references');
        $permission->addRole('authenticated');

        /* seznam zdrojů */
        $permission->addResource('Admin:Main');
        $permission->addResource('Admin:Header');
        $permission->addResource('Admin:Members');
        $permission->addResource('Admin:References');
        $permission->addResource('Admin:Summary');
        $permission->addResource('Admin:');

        /* zákldní pole zdrojů */
        $basicArray = array('Admin:', 'Admin:Main', 'Admin:Header', 'Admin:Members', 'Admin:References', 'Admin:Summary');

        /* základní pole práv */
        $defaultPrivileges = array('default', 'detail', 'logout');

        /* přiřazení základních oprávnění */
        $permission->allow('admin', $basicArray, $defaultPrivileges);
        $permission->allow('header', $basicArray, $defaultPrivileges);

        /* pole privilegií k úpravám */
        $managePrivileges = array('create','delete','edit', 'handle', 'new');

        //muze upravovat hlavicku
        $permission->allow('header', 'Admin:Header', $managePrivileges);

        //muze upravovat členy
        $permission->allow('members', 'Admin:Members', $managePrivileges);

        //muze upravovat reference
        $permission->allow('references', 'Admin:References', $managePrivileges);

        /* ADMIN má práva na všechno */
        $permission->allow('admin', $basicArray, $managePrivileges);
        $permission->allow('admin', Permission::ALL, Permission::ALL);


        return $permission;
    }

}