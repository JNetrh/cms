<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 19:14
 */
namespace App\Model\Services;

use App\Model\Entities\BlockEvents;
use App\Model\Entities\Event;
use Kdyby\Doctrine\EntityManager;

class EventService
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
        $this->entities = $this->entityManager->getRepository(BlockEvents::class);
    }

    public function newEntity(){
        $entity = new BlockEvents;
        return $entity;
    }

    public function saveEntity($entity){
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function createEntity($name, $text, $eventTime, $image, $owner, $active)
    {
        $entity = new BlockEvents;
        $entity->setHeading($name);
        $entity->setText($text);
        $entity->setEventTime($eventTime);
        $entity->setImage($image);
        $entity->setOwner($owner);
        $entity->setActive($active);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function newSubEntity($blockId){
        $blockId = intval($blockId);
        $entity = new Event();
        $this->findById($blockId)->setEvent($entity);
        return $entity;
    }

//    public function createSubEntity($id){
//        $entity = $this->entityManager->findById($id)->createEntity();
//        $this->entityManager->persist($entity);
//        $this->entityManager->flush();
//    }

    public function delete($id){
        $toDel = $this->findById($id);
        $toDel->getEvents()->map(function(Event $el){
            $el->deleteImage();
        });
        $toDel->deleteImage();
        $this->entityManager->remove($toDel);
        $this->entityManager->flush();
    }

    public function deleteEvent($blockId, $id){
        $toDel = $this->findById($blockId)->removeEvent($this->findSubById($blockId, $id));
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