<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 28.3.2018
 * Time: 19:14
 */
namespace App\Model\Services;

use App\Model\Entities\BlockArticles;
use Kdyby\Doctrine\EntityManager;

class ArticleService
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
        $this->entities = $this->entityManager->getRepository(BlockArticles::class);
    }

    public function newEntity(){
        $entity = new BlockArticles;
        return $entity;
    }

    public function saveEntity($entity){
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function createEntity($style, $bgType, $heading1, $heading2, $text, $imageArticle, $image, $position, $active)
    {
        $entity = new BlockArticles;
        $entity->setStyle($style);
        $entity->setBgType($bgType);
        $entity->setHeading1($heading1);
        $entity->setHeading2($heading2);
        $entity->setText($text);
        $entity->setImageArticle($imageArticle);
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