<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 28.3.2018
 * Time: 12:45
 */
namespace App\Model\Services;

use App\Model\Entities\BlockContacts;
use Kdyby\Doctrine\EntityManager;

class ContactService
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityManager
     */
    private $entities;

    /**
     * ContactService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entities = $this->entityManager->getRepository(BlockContacts::class);
    }

    /**
     * @return BlockContacts
     */
    public function newEntity(){
        $entity = new BlockContacts;
        return $entity;
    }

    /**
     * @param $entity
     * @throws \Exception
     */
    public function saveEntity($entity){
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param $style
     * @param $bgType
     * @param $image
     * @param $position
     * @param $active
     * @param $heading_1
     * @param $heading_2
     * @param $email
     * @param $phone
     * @param $adress
     * @param $gpsX
     * @param $gpsY
     * @param $instagram
     * @param $facebook
     * @param $twitter
     * @param $linkedin
     * @throws \Exception
     */
    public function createEntity($style, $bgType, $image, $position, $active, $heading_1, $heading_2, $email, $phone, $adress, $gpsX, $gpsY, $instagram, $facebook, $twitter, $linkedin)
    {
        $entity = new BlockContacts;
        $entity->setStyle($style);
        $entity->setBgType($bgType);
        $entity->setImage($image);
        $entity->setPosition($position);
        $entity->setActive($active);
        $entity->setHeading1($heading_1);
        $entity->setHeading2($heading_2);
        $entity->setEmail($email);
        $entity->setPhone($phone);
        $entity->setAdress($adress);
        $entity->setGpsX($gpsX);
        $entity->setGpsY($gpsY);
        $entity->setInstagram($instagram);
        $entity->setFacebook($facebook);
        $entity->setTwitter($twitter);
        $entity->setLinkedin($linkedin);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }



    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id){
        $toDel = $this->findById($id);
        $toDel->deleteImage();
        $this->entityManager->remove($toDel);
        $this->entityManager->flush();
    }


    /**
     * @param $var
     * @param $val
     * @return BlockContacts
     */
    public function findByVar($var, $val) {
        return $this->entities->findOneBy(array($var => $val));
    }

    /**
     * @param $val
     * @return BlockContacts
     */
    public function findById($val) {
        return $this->entities->findOneBy(array('id' => $val));
    }

    /**
     * @return array
     */
    public function getEntities() {
        return $this->entities->findAll();
    }

}