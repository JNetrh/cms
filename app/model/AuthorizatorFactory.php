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
        $permission->addRole('headers');
        $permission->addRole('members');
        $permission->addRole('references');
        $permission->addRole('events');
        $permission->addRole('contacts');
        $permission->addRole('articles');
        $permission->addRole('sponsors');
        $permission->addRole('menu');
        $permission->addRole('seo');
        $permission->addRole('authenticated');
        /* TODO: Insert previous values to DB */

        /* seznam zdrojů */
        $permission->addResource('Admin:Main');
        $permission->addResource('Admin:Header');
        $permission->addResource('Admin:Members');
        $permission->addResource('Admin:References');
        $permission->addResource('Admin:Events');
        $permission->addResource('Admin:Contacts');
        $permission->addResource('Admin:Articles');
        $permission->addResource('Admin:Sponsors');
        $permission->addResource('Admin:Menu');
        $permission->addResource('Admin:Seo');
        $permission->addResource('Admin:Summary');
        $permission->addResource('Admin:');

        /* zákldní pole zdrojů */
        $basicArray = array('Admin:', 'Admin:Main', 'Admin:Header', 'Admin:Members', 'Admin:References', 'Admin:Summary', 'Admin:Events', 'Admin:Contacts', 'Admin:Articles', 'Admin:Sponsors', 'Admin:Menu', 'Admin:Seo');

        /* základní pole práv */
        $defaultPrivileges = array('default', 'detail', 'logout');

        /* přiřazení základních oprávnění */
        $permission->allow('admin', $basicArray, $defaultPrivileges);
        $permission->allow('headers', $basicArray, $defaultPrivileges);
        $permission->allow('members', $basicArray, $defaultPrivileges);
        $permission->allow('references', $basicArray, $defaultPrivileges);
        $permission->allow('events', $basicArray, $defaultPrivileges);
        $permission->allow('contacts', $basicArray, $defaultPrivileges);
        $permission->allow('articles', $basicArray, $defaultPrivileges);
        $permission->allow('sponsors', $basicArray, $defaultPrivileges);
        $permission->allow('menu', $basicArray, $defaultPrivileges);
        $permission->allow('seo', $basicArray, $defaultPrivileges);

        /* pole privilegií k úpravám */
        $managePrivileges = array('create','delete','edit', 'handle', 'new');

        //muze upravovat hlavicku
        $permission->allow('headers', 'Admin:Header', $managePrivileges);

        //muze upravovat členy
        $permission->allow('members', 'Admin:Members', $managePrivileges);

        //muze upravovat reference
        $permission->allow('references', 'Admin:References', $managePrivileges);

        //muze upravovat eventy
        $permission->allow('events', 'Admin:Events', $managePrivileges);

        //muze upravovat kontakty
        $permission->allow('contacts', 'Admin:Events', $managePrivileges);

        //muze upravovat články
        $permission->allow('articles', 'Admin:Articles', $managePrivileges);

        //muze upravovat sponsory
        $permission->allow('sponsors', 'Admin:Sponsors', $managePrivileges);

        //muze upravovat Menu
        $permission->allow('menu', 'Admin:Menu', $managePrivileges);

        //muze upravovat SEO
        $permission->allow('seo', 'Admin:Seo', $managePrivileges);

        /* ADMIN má práva na všechno */
        $permission->allow('admin', $basicArray, $managePrivileges);
        $permission->allow('admin', Permission::ALL, Permission::ALL);


        return $permission;
    }

}