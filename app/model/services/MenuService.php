<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 4.4.2018
 * Time: 10:20
 */
namespace App\Model\Services;

use App\Model\Entities\BlockMenus;
use App\Model\Entities\Menu;
use Kdyby\Doctrine\EntityManager;

class MenuService
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
        $this->entities = $this->entityManager->getRepository(BlockMenus::class);
    }

    public function newEntity(){
        $entity = new BlockMenus;
        return $entity;
    }

    public function saveEntity($entity){
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

	/**
	 * ONLY for MenuPresenter!
	 * @param $entity
	 */
    public function updateEntity($entity){
	    $this->entityManager->persist($entity);
    }

	/**
	 * ONLY for MenuPresenter!
	 */
    public function saveChanges(){
	    $this->entityManager->flush();
    }

//    public function createEntity($style, $bgType, $image, $instagram, $facebook, $twitter, $linkedin, $heading)
    public function createEntity($style, $bgType)
    {
        $entity = new BlockMenus();
        $entity->setStyle($style);
        $entity->setBgType($bgType);
//        $entity->setImage($image);
//        $entity->setInstagram($instagram);
//        $entity->setFacebook($facebook);
//        $entity->setTwitter($twitter);
//        $entity->setLinkedin($linkedin);
//        $entity->setHeading($heading);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity;
    }

    public function newSubEntity($blockId){
        $blockId = intval($blockId);
        $entity = new Menu();
        $this->findById($blockId)->setMenu($entity);
        return $entity;
    }

    public function createSubEntity($id){
        $entity = $this->entityManager->findById($id)->createEntity();
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete($id){
        $toDel = $this->findById($id);
        $toDel->deleteImage();
        $this->entityManager->remove($toDel);
        $this->entityManager->flush();
    }

    public function deleteMenu($blockId, $id){
        $toDel = $this->findById($blockId)->removeMenu($this->findSubById($blockId, $id));
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

    public function getOne() {
    	$menu = $this->entities->findAll();
    	if(count($menu) == 0){
    		$menu = $this->createEntity('{"footer_text_color":"#454545","footer_background_color":"#f2f2f2","heading_color":"#ffffff","background_color":"#631192","inverted_background_color":"#ffffff","text_color":"#ffffff","inverted_text_color":"#631192"}', 'color');
	    }
	    else {
		    $menu = $menu[0];
	    }
	    return $menu;
//	    return $this->entities->findAll()[0];
    }

    public function findSubById($blockId, $subId){
        return $this->findById($blockId)->findById($subId);

    }

}



