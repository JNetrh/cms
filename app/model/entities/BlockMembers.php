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
use App\Model\Entities\Member;

/**
 * Doctrine entita
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="block_members")
 */
class BlockMembers
{


    use Identifier;

    /**
     * @ORM\OneToMany(targetEntity="Member", mappedBy="ref")
     */
    private $members;

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
    protected $heading_1;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $image;


    /**
     * right name column
     * @ORM\Column(type="boolean")
     */
    protected $active;


    /**
     * right name column
     * @ORM\Column(type="integer")
     */
    protected $position;


    /**
     * BlockMembers constructor, initializes collections
     */
    public function __construct()
    {
        $this->members = new ArrayCollection();
    }


    /**
     * @return array of form properties
     */
    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'heading_1' => $this->getHeading(),
            'position' => $this->getPosition(),
            'active' => $this->getActive(),
            'image' => $this->getImage()
        ];
    }

    /**
     * @return array of colors dedicated to the block
     */
    public function getColorProperties(){

        $style = json_decode($this->getStyle());


        return [
            'heading_1_color' => $style->heading_1_color,
            'text_color' => $style->text_color,
            'name_color' => $style->name_color,
            'background_color' => $style->background_color
        ];
    }


    /**
     * @param $name
     * @param $text
     * @param $image
     * @param $owner
     * @param $active
     * @return \App\Model\Entities\Member
     */
    public function createEntity($name, $text, $image, $owner, $active)
    {
        $entity = new Member();
        $entity->setName($name);
        $entity->setText($text);
        $entity->setImage($image);
        $entity->setOwner($owner);
        $entity->setActive($active);

//        $this->members[] = $entity;

        return $entity;
    }

    /**
     * @return integer
     */
    public function membersCount()
    {
        return count($this->members);
    }

    /**
     * Deletes image from server
     */
    public function deleteImage(){
        if(file_exists($this->getImage())){
            unlink($this->getImage());
        }
        $this->setImage(null);
    }

    /**
     * @param $id of the searching member block
     * @return Member
     */
    public function findById($id){
        foreach ($this->members as $el){
            if($el->getId() == $id){
                return $el;
            }
        }
    }


    /**
     * set the member dedicated to this block
     * @param \App\Model\Entities\Member $member
     */
    public function setMember (Member $member){
        $this->members->add($member);
    }

    /**
     * remove member dedicated to this block and returns it back
     * @param \App\Model\Entities\Member $member
     * @return \App\Model\Entities\Member
     */
    public function removeMember(Member $member){
        $this->members->remove($member->getId());
        return $member;
    }

    /**
     * @return string
     */
    public function getMembers()
    {
        return $this->members;
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
        return $this->heading_1;
    }

    /**
     * @param string $heading_1
     */
    public function setHeading($heading_1)
    {
        $this->heading_1 = $heading_1;
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
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param integer $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param integer $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
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
        return 'members';
    }


}