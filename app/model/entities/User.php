<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 17:39
 */

namespace App\Model\Entities;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * Doctrine entita pro tabulku user.
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{

    /**
     * @var \Doctrine\Common\Collections\Collection|UserRight[]
     *
     * @ORM\ManyToMany(targetEntity="Right", inversedBy="users")
     * @ORM\JoinTable(
     *  name="userrights",
     *  joinColumns={
     *      @ORM\JoinColumn(name="userId", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="rightId", referencedColumnName="id")
     *  }
     * )
     */
    protected $rights;
    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->rights = new ArrayCollection();
    }

    public function getRights(){
        return $this->rights;
    }


    /**
     * @param UserRight $userRight
     */
    public function addUserRight(UserRight $userRight)
    {
        if ($this->rights->contains($userRight)) {
            return;
        }
        $this->rights->add($userRight);
        $userRight->addUser($this);
    }
    /**
     * @param UserRight $userRight
     */
    public function removeUserRight(UserRight $userRight)
    {
        if (!$this->rights->contains($userRight)) {
            return;
        }
        $this->rights->removeElement($userRight);
        $userRight->removeUser($this);
    }

    // Proměné reprezentující jednotlivé sloupce tabulky.


    use Identifier;


    /**
     * Sloupec pro heslo.
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * Sloupec pro email.
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }






}
