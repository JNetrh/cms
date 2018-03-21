<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 19:14
 */
namespace App\Model\Services;

use App\Model\Entities\BlockMembers;
use App\Model\Entities\Member;
use Kdyby\Doctrine\EntityManager;

class MemberService
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
//        TODO: udělat stejně ostatní,
//        TODO: nastavit v sql ondelete cascade!
        $this->entityManager = $entityManager;
        $this->entities = $this->entityManager->getRepository(BlockMembers::class);
    }

    public function newEntity(){
        $entity = new BlockMembers;
        return $entity;
    }

    public function saveEntity($entity){
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function createEntity($style, $bgType, $image, $position, $active, $heading)
    {
        $entity = new BlockMembers;
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

        $entity = $this->entityManager->findById($id)->createEntity();

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete($id){
        $toDel = $this->findById($id);
        $toDel->getMembers()->map(function(Member $el){
            $el->deleteImage();
        });
        $toDel->deleteImage();
        $this->entityManager->remove($toDel);
        $this->entityManager->flush();
    }

    public function deleteMember($blockId, $id){
        $toDel = $this->findById($blockId)->removeMember($this->findSubById($blockId, $id));
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

    public function newSubMember($blockId){
        $blockId = intval($blockId);
        $entity = new Member();
        bdump($blockId);
        bdump($this->findById($blockId));
        $this->findById($blockId)->setMember($entity);
        return $entity;
    }

}