<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 10.4.2018
 * Time: 13:19
 */
namespace App\Model\Services;

use App\Model\Entities\Seo;
use Kdyby\Doctrine\EntityManager;

class SeoService
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
        $this->entities = $this->entityManager->getRepository(Seo::class);
    }

    public function newEntity(){
        $entity = new Seo();
        return $entity;
    }

    public function saveEntity($entity){
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

	/**
	 * ONLY for Seo!
	 * @param $entity
	 */
    public function updateEntity($entity){
	    $this->entityManager->persist($entity);
    }

	/**
	 * ONLY for Seo!
	 */
    public function saveChanges(){
	    $this->entityManager->flush();
    }

    public function createEntity()
    {
        $entity = new Seo();
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity;
    }

	public function getOne() {
		$seo = $this->entities->findAll();
		if(count($seo) == 0){
			$seo = $this->createEntity();
		}
		else {
			$seo = $seo[0];
		}
		return $seo;
	}

}



