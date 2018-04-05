<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 17:40
 */

namespace App\Model\Entities;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use App\Model\Entities\Menu;

/**
 * Doctrine entita
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="block_menus")
 */
class BlockMenus
{


    use Identifier;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="ref")
     */
    private $menus;

    /**
     * right name column
     * @ORM\Column(type="text")
     */
    protected $style;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $bg_type;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $heading;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $image;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $instagram;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $facebook;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $twitter;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $linkedin;


    /**
     * BlockMenus constructor, initializes collections
     */
    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }


    /**
     * @return array of form properties
     */
    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'heading' => $this->getHeading(),
            'image' => $this->getImage(),
            'facebook' => $this->getFacebook(),
            'instagram' => $this->getInstagram(),
            'twitter' => $this->getTwitter(),
            'linkedin' => $this->getLinkedin()
        ];
    }

    /**
     * @return array of colors dedicated to the block
     */
    public function getColorProperties(){

        $style = json_decode($this->getStyle());


        return [
            'heading_color' => $style->heading_color,
            'text_color' => $style->text_color,
            'inverted_text_color' => $style->inverted_text_color,
            'background_color' => $style->background_color,
            'inverted_background_color' => $style->inverted_background_color
        ];
    }


	/**
	 * @param $link
	 * @param $text
	 * @param $position
	 * @param $owner
	 * @param $active
	 * @param $blockOwner
	 *
	 * @return \App\Model\Entities\Menu
	 */
    public function createEntity($link, $text, $position, $owner, $active, $blockOwner)
    {
        $entity = new Menu();
        $entity->setLink($link);
        $entity->setText($text);
        $entity->setPosition($position);
        $entity->setOwner($owner);
        $entity->setActive($active);
        $entity->setBlockOwner($blockOwner);

//        $this->menus[] = $entity;

        return $entity;
    }

    /**
     * @return integer
     */
    public function menusCount()
    {
        return count($this->menus);
    }


    /**
     * @param $id of the searching menu item
     * @return Menu
     */
    public function findById($id){
        foreach ($this->menus as $el){
            if($el->getId() == $id){
                return $el;
            }
        }
    }

	/**
	 * @param $extId of the searching menu item
	 *
	 * @return Menu|null
	 */
    public function findByBlock($extId){
	    foreach ($this->menus as $el){
		    if($el->getBlockOwner() === $extId){
			    return $el;
		    }
	    }
	    return null;
    }


    /**
     * set the menu item dedicated to this block
     * @param \App\Model\Entities\Menu $menu
     */
    public function setMenu (Menu $menu){
        $this->menus->add($menu);
    }

    /**
     * remove menu item dedicated to this block and returns it back
     * @param \App\Model\Entities\Menu $menu
     * @return \App\Model\Entities\Menu
     */
    public function removeMenu(Menu $menu){
        $this->menus->remove($menu->getId());
        return $menu;
    }

    public function deleteImage(){
    	$this->setImage(null);
    }

    /**
     * @return mixed
     */
    public function getMenus()
    {
        return $this->menus;
    }

	/**
	 * @return mixed
	 */
	public function getInstagram() {
		return $this->instagram;
	}

	/**
	 * @param mixed $instagram
	 */
	public function setInstagram( $instagram ) {
		$this->instagram = $instagram;
	}

	/**
	 * @return string
	 */
	public function getFacebook() {
		return $this->facebook;
	}

	/**
	 * @param string $facebook
	 */
	public function setFacebook( $facebook ) {
		$this->facebook = $facebook;
	}

	/**
	 * @return string
	 */
	public function getTwitter() {
		return $this->twitter;
	}

	/**
	 * @param string $twitter
	 */
	public function setTwitter( $twitter ) {
		$this->twitter = $twitter;
	}

	/**
	 * @return string
	 */
	public function getLinkedin() {
		return $this->linkedin;
	}

	/**
	 * @param string $linkedin
	 */
	public function setLinkedin( $linkedin ) {
		$this->linkedin = $linkedin;
	}



    /**
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param string $style
     */
    public function setStyle($style)
    {
        $this->style = $style;
    }

    /**
     * @return string
     */
    public function getBgType()
    {
        return $this->bg_type;
    }

    /**
     * @param string $bg_type
     */
    public function setBgType($bg_type)
    {
        $this->bg_type = $bg_type;
    }

    /**
     * @return string
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param string $heading
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
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
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

	/**
	 * @return string
	 */
	public function getMainHeading(){
		return $this->getHeading();
	}

    /**
     * @return string
     */
    public function toString(){
        return 'menus';
    }


}