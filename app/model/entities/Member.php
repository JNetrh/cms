<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 17:40
 */

namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * Doctrine entita
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="members")
 */
class Member
{


    use Identifier;



    /**
     * @ORM\ManyToOne(targetEntity="BlockMembers", inversedBy="members")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id", onDelete="CASCADE")
     */
    private $ref;

    /**
     * right name column
     * @ORM\Column(type="text")
     */
    protected $name;


    /**
     * right name column
     * @ORM\Column(type="text")
     */
    protected $text;



    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $image;


    /**
     * right name column
     * @ORM\Column(type="integer")
     */
    protected $owner;



    /**
     * right name column
     * @ORM\Column(type="boolean")
     */
    protected $active;


    /**
     * deletes image that corresponds with this subBlock
     */
    public function deleteImage(){
        if(is_file($this->getImage())){
            unlink($this->getImage());
        }
        $this->setImage(null);
    }


    /**
     * @return array of default form properties
     */
    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'text' => $this->getText(),
            'image' => $this->getImage(),
            'owner' => $this->getOwner(),
            'active' => $this->getActive()
        ];
    }




    /**
     * @return integer
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
     * @return BlockMembers
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param BlockMembers $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param int $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner->getId();
        $this->setRef($owner);
    }

    /**
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

}