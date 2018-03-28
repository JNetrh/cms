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
        $permission->addRole('events');
        $permission->addRole('contacts');
        $permission->addRole('authenticated');

        /* seznam zdrojů */
        $permission->addResource('Admin:Main');
        $permission->addResource('Admin:Header');
        $permission->addResource('Admin:Members');
        $permission->addResource('Admin:References');
        $permission->addResource('Admin:Events');
        $permission->addResource('Admin:Contacts');
        $permission->addResource('Admin:Summary');
        $permission->addResource('Admin:');

        /* zákldní pole zdrojů */
        $basicArray = array('Admin:', 'Admin:Main', 'Admin:Header', 'Admin:Members', 'Admin:References', 'Admin:Summary', 'Admin:Events', 'Admin:Contacts');

        /* základní pole práv */
        $defaultPrivileges = array('default', 'detail', 'logout');

        /* přiřazení základních oprávnění */
        $permission->allow('admin', $basicArray, $defaultPrivileges);
        $permission->allow('header', $basicArray, $defaultPrivileges);
        $permission->allow('members', $basicArray, $defaultPrivileges);
        $permission->allow('references', $basicArray, $defaultPrivileges);
        $permission->allow('events', $basicArray, $defaultPrivileges);
        $permission->allow('contacts', $basicArray, $defaultPrivileges);

        /* pole privilegií k úpravám */
        $managePrivileges = array('create','delete','edit', 'handle', 'new');

        //muze upravovat hlavicku
        $permission->allow('header', 'Admin:Header', $managePrivileges);

        //muze upravovat členy
        $permission->allow('members', 'Admin:Members', $managePrivileges);

        //muze upravovat reference
        $permission->allow('references', 'Admin:References', $managePrivileges);

        //muze upravovat eventy
        $permission->allow('events', 'Admin:Events', $managePrivileges);

        //muze upravovat kontakty
        $permission->allow('contacts', 'Admin:Events', $managePrivileges);

        /* ADMIN má práva na všechno */
        $permission->allow('admin', $basicArray, $managePrivileges);
        $permission->allow('admin', Permission::ALL, Permission::ALL);


        return $permission;
    }

}