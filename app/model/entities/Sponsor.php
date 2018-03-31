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
 * @ORM\Table(name="sponsors")
 */
class Sponsor
{


    use Identifier;



    /**
     * @ORM\ManyToOne(targetEntity="BlockSponsors", inversedBy="sponsors")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id", onDelete="CASCADE")
     */
    private $ref;

    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $link;


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
     * deletes image that corresponds with this subBlock
     */
    public function deleteImage(){
        $this->setImage(null);
    }


    /**
     * @return array of default form properties
     */
    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'link' => $this->getLink(),
            'image' => $this->getImage(),
            'owner' => $this->getOwner()
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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
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
        if(file_exists($this->getImage())){
            unlink($this->getImage());
        }
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

}