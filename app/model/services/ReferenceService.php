<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 19:14
 */
namespace App\Model\Services;

use App\Model\Entities\BlockReferences;
use Kdyby\Doctrine\EntityManager;

class ReferenceService
{

    /**
     * @var EntityManager
     */
    private $entities;

    public function __construct(EntityManager $entityManager)
    {
        $this->entities = $entityManager->getRepository(BlockReferences::class);
    }

    public function createEntity($style, $bgType, $image, $position, $active, $heading)
    {
        $entity = new BlockReferences;
        $entity->setStyle($style);
        $entity->setBgType($bgType);
        $entity->setImage($image);
        $entity->setPosition($position);
        $entity->setActive($active);
        $entity->setHeading($heading);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function createSubEntity($id){

        $entity = $this->findById($id)->createEntity();

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findByVar($var, $val) {
        return $this->entities->findOneBy(array($var => $val));
    }

    public function findById($val) {
        return $this->entities->findOneBy(array('id' => $val));
    }

    public function getEntities() {
        return $this->entities->findAll();
    }

}