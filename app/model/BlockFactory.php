<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 13.3.2018
 * Time: 13:08
 */

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityManager;

use App\Model\Services\ReferenceService;
use App\Model\Services\MemberService;
use App\Model\Services\HeaderService;
use App\Model\Services\EventService;
use App\Model\Services\ContactService;
use App\Model\Services\ArticleService;
use App\Model\Services\SponsorService;

use App\Model\Services\MenuService;


class BlockFactory
{
	/**
	 * @var EntityManager
	 */
	private $entityManager;

    private $references;
    private $members;
    private $headers;
    private $events;
    private $contacts;
    private $articles;
    private $sponsors;

    private $menu;


    public function __construct(
    	EntityManager $entityManager,
        ReferenceService $references,
        MemberService $members,
        HeaderService $headers,
        EventService $events,
        ContactService $contacts,
        ArticleService $articles,
        SponsorService $sponsors,

        MenuService $menu
    )
    {
	    $this->entityManager = $entityManager;

        $this->references = $references;
        $this->members = $members;
        $this->headers = $headers;
        $this->events = $events;
        $this->contacts = $contacts;
        $this->articles = $articles;
        $this->sponsors = $sponsors;

        $this->menu = $menu;
    }


    /**
     * @return mixed
     */
    public function getBlockMembers()
    {
        return $this->members;
    }


    /**
     * @return mixed
     */
    public function getBlockHeader()
    {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getBlockReferences()
    {
        return $this->references;
    }

    /**
     * @return mixed
     */
    public function getBlockEvents()
    {
        return $this->events;
    }

    /**
     * @return mixed
     */
    public function getBlockContacts()
    {
        return $this->contacts;
    }

    /**
     * @return mixed
     */
    public function getBlockArticles()
    {
        return $this->articles;
    }

    /**
     * @return mixed
     */
    public function getBlockSponsors()
    {
        return $this->sponsors;
    }

    /**
     * @return mixed
     */
    public function getBlockMenus()
    {
        return $this->menu;
    }


    public function getAllBlocks(){
        return $this->mergeBlocks();
    }

    private function mergeBlocks(){
        $merged = array_merge($this->getBlockMembers()->getEntities(), $this->getBlockHeader()->getEntities(), $this->getBlockReferences()->getEntities(), $this->getBlockEvents()->getEntities(), $this->getBlockContacts()->getEntities(), $this->getBlockArticles()->getEntities(), $this->getBlockSponsors()->getEntities());

        usort($merged, function ($a, $b) {
            if($a->getPosition() == $b->getPosition()){ return 0 ; }
            return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
        });

        return $merged;
    }

    public function setMenu($entity){
    	$myBlock = $this->searchBlock($entity);
    	$idExt = $myBlock->toString()."_".$myBlock->getId();
    	$blockMenus = $this->getBlockMenus()->getOne();
	    $menusEntity = $blockMenus->findByBlock($idExt);

	    if($menusEntity == null){
	    	$menusEntity = $blockMenus->createEntity(
	    		$idExt,
			    $entity->getMainHeading(),
			    $entity->getPosition(),
			    $blockMenus,
			    $entity->getActive(),
			    $idExt
		    );
	    }
	    else {
		    $menusEntity->setBlockOwner($idExt);
		    $menusEntity->setText($entity->getMainHeading());
	    }

	    $this->entityManager->persist($menusEntity);
	    $this->entityManager->flush();


    }

    public function deleteMenu($entity){
	    $myBlock = $this->searchBlock($entity);
	    $idExt = $myBlock->toString()."_".$myBlock->getId();
	    $blockMenus = $this->getBlockMenus()->getOne();
	    $menusEntity = $blockMenus->findByBlock($idExt);

	    if($menusEntity != null) {
		    $this->entityManager->remove($menusEntity);
		    $this->entityManager->flush();
	    }
    }

    private function searchBlock ($entity){
	    foreach ($this->getAllBlocks() as $row){
		    $id = $row->getId();
		    $name = $row->toString();
		    if($entity->getId() == $id and $entity->toString() == $name){
			    return $row;
		    }
	    }
    }

    public function searchByIdExt ($string, $id){
	    foreach ($this->getAllBlocks() as $row){
		    $cId = $row->getId();
		    $name = $row->toString();
		    if(intval($id) == intval($cId) and $string == $name){
			    return $row;
		    }
	    }
    }



}