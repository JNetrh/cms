<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 19:14
 */
namespace App\Model\Services;

use App\Model\Entities\BlockHeader;
use Kdyby\Doctrine\EntityManager;

class HeaderService
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
        $this->entities = $this->entityManager->getRepository(BlockHeader::class);
    }

    public function newEntity(){
        $entity = new BlockHeader;
        return $entity;
    }

    public function saveEntity($entity){
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function createEntity($style, $bgType, $heading1, $heading2, $button1, $button2, $button1Link, $button2Link, $image, $position, $active)
    {
        $entity = new BlockHeader;
        $entity->setStyle($style);
        $entity->setBgType($bgType);
        $entity->setHeading1($heading1);
        $entity->setHeading2($heading2);
        $entity->setButton1($button1);
        $entity->setButton2($button2);
        $entity->setButton1Link($button1Link);
        $entity->setButton2Link($button2Link);
        $entity->setImage($image);
        $entity->setPosition($position);
        $entity->setActive($active);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete($id){
        $toDel = $this->findById($id);
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

}