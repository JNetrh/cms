<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 19:14
 */
namespace App\Model\Services;

use App\Model\Entities\BlockReferences;
use App\Model\Entities\Reference;
use Kdyby\Doctrine\EntityManager;

class ReferenceService
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityManager
     */
    private $entities;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entities = $this->entityManager->getRepository(BlockReferences::class);
    }

    public function newEntity(){
        $entity = new BlockReferences();
        return $entity;
    }

    public function saveEntity($entity){
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
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

    public function newSubEntity($blockId){
        $blockId = intval($blockId);
        $entity = new Reference();
        $this->findById($blockId)->setReference($entity);
        return $entity;
    }

    public function createSubEntity($id){
        $entity = $this->entityManager->findById($id)->createEntity();
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete($id){
        $toDel = $this->findById($id);
        $toDel->getReferences()->map(function(Reference $el){
            $el->deleteImage();
        });
        $toDel->deleteImage();
        $this->entityManager->remove($toDel);
        $this->entityManager->flush();
    }

    public function deleteReference($blockId, $id){
        $toDel = $this->findById($blockId)->removeReference($this->findSubById($blockId, $id));
        $toDel->deleteImage();
        $this->entityManager->remove($toDel);
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

    public function findSubById($blockId, $subId){
        return $this->findById($blockId)->findById($subId);

    }

}