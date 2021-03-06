<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 19:14
 */
namespace App\Model\Services;

use App\Model\Entities\User as User;
use Kdyby\Doctrine\EntityManager;
use Doctrine\DBAL\Exception\ConnectionException as connException;

class UserService
{

    /**
     * @var EntityManager
     */
    private $entities;

    public function __construct(EntityManager $entityManager)
    {
    	try {
		    $this->entities = $entityManager->getRepository(User::class);
	    }
	    catch (connException $e){

	    }
    }

    public function createEntity($email, $password)
    {
        $entity = new User;
        $entity->setEmail($email);
        $entity->setPassword($password);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }


    public function findByEmail($email)
    {
        return $this->entities->findOneBy(array('email' => $email));
    }

    public function findByVar($var, $val) {
        return $this->entities->findOneBy(array($var => $val));
    }

}