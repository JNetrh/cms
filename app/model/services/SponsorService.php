<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 28.3.2018
 * Time: 19:14
 */
namespace App\Model\Services;

use App\Model\Entities\BlockSponsors;
use App\Model\Entities\Sponsor;
use Kdyby\Doctrine\EntityManager;

class SponsorService
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
        $this->entities = $this->entityManager->getRepository(BlockSponsors::class);
    }

    public function newEntity(){
        $entity = new BlockSponsors;
        return $entity;
    }

    public function saveEntity($entity){
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function createEntity($style, $bgType, $heading, $image, $position, $active)
    {
        $entity = new BlockSponsors();
        $entity->setStyle($style);
        $entity->setBgType($bgType);
        $entity->setHeading($heading);
        $entity->setImage($image);
        $entity->setPosition($position);
        $entity->setActive($active);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function newSubEntity($blockId){
        $blockId = intval($blockId);
        $entity = new Sponsor();
        $this->findById($blockId)->setSponsor($entity);
        return $entity;
    }

    public function createSubEntity($id){
        $entity = $this->entityManager->findById($id)->createEntity();
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete($id){
        $toDel = $this->findById($id);
        $toDel->getSponsors()->map(function(Sponsor $el){
            $el->deleteImage();
        });
        $toDel->deleteImage();
        $this->entityManager->remove($toDel);
        $this->entityManager->flush();
    }

    public function deleteSponsor($blockId, $id){
        $toDel = $this->findById($blockId)->removeSponsor($this->findSubById($blockId, $id));
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