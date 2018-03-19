<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 21:41
 */
namespace App\Model\Services;

use App\Model\Entities\Right;
use Kdyby\Doctrine\EntityManager;

class RightsService
{

    /**
     * @var EntityManager
     */
    private $entities;

    public function __construct(EntityManager $entityManager)
    {
        $this->entities = $entityManager->getRepository(Right::class);
    }

    public function createEntity($name)
    {
        $entity = new Right;
        $entity->setName($name);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findByName($find)
    {
        return $this->entities->findOneBy(array('name' => $find));
    }

    public function findByRightId($find)
    {
        return $this->entities->findOneBy(array('id' => $find));
    }

    public function findByVar($var, $val) {
        return $this->entities->findOneBy(array($var => $val));
    }

}