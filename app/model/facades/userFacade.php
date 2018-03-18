<?php

namespace App\Model\Facades;

use App\Model\Entities\User;
use Kdyby\Doctrine\EntityManager;
use Nette\Object;

/**
 * Fasáda pro manipulaci s uživateli.
 * @package App\Model\Facades
 */
class UserFacade extends Object
{
    /** @var EntityManager Manager pro práci s entitami. */
    private $em;

    /**
     * Konstruktor s injektovanou třídou pro práci s entitami.
     * @param EntityManager $em automaticky injektovaná třída pro práci s entitami
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Najde a vrátí uživatele podle jeho ID.
     * @param int|NULL $id ID uživatele
     * @return User|NULL vrátí entitu uživatele nebo NULL pokud uživatel nebyl nalezen
     */
    public function getUser($id)
    {
        return isset($id) ? $this->em->find(User::class, $id) : NULL;
    }
}