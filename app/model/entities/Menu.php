<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 4.4.2018
 * Time: 09:40
 */

namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * Doctrine entita
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="menus")
 */
class Menu
{


    use Identifier;



    /**
     * @ORM\ManyToOne(targetEntity="BlockMenus", inversedBy="menus")
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
	protected $text;


	/**
	 * right name column
	 * @ORM\Column(type="integer")
	 */
	protected $position;


    /**
     * right name column
     * @ORM\Column(type="integer")
     */
    protected $owner;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $block_owner;



    /**
     * right name column
     * @ORM\Column(type="boolean")
     */
    protected $active;


    /**
     * @return array of default form properties
     */
    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'link' => $this->getLink(),
            'text' => $this->getText(),
            'owner' => $this->getOwner(),
            'position' => $this->getPosition(),
            'active' => $this->getActive()
        ];
    }




    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return BlockMenus
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param BlockMenus $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

	/**
	 * @return mixed
	 */
	public function getBlockOwner() {
		return $this->block_owner;
	}

	/**
	 * @param mixed $blockOwner
	 */
	public function setBlockOwner( $blockOwner ) {
		$this->block_owner = $blockOwner;
	}

	/**
	 * @return mixed
	 */
	public function getLink() {
		return $this->link;
	}

	/**
	 * @param mixed $link
	 */
	public function setLink( $link ) {
		$this->link = $link;
	}

	/**
	 * @return mixed
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * @param mixed $position
	 */
	public function setPosition( $position ) {
		$this->position = $position;
	}



    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }


    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner->getId();
        $this->setRef($owner);
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

}