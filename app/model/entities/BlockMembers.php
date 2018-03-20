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






    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'heading_1' => $this->getHeading(),
            'position' => $this->getPosition(),
            'active' => $this->getActive(),
            'image' => $this->getImage()
        ];
    }
    public function getColorProperties(){

        $style = json_decode($this->getStyle());


        return [
            'heading_1_color' => $style->heading_1_color,
            'text_color' => $style->text_color,
            'name_color' => $style->name_color,
            'background_color' => $style->background_color
        ];
    }



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
     * @return mixed
     */
    public function membersCount()
    {
        return count($this->members);
//        TODO: změnit
//        return 2;
    }



    /**
     * @return mixed
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param mixed $style
     */
    public function setStyle($style)
    {
        $this->style = $style;
    }

    /**
     * @return mixed
     */
    public function getBgType()
    {
        return $this->bg_type;
    }

    /**
     * @param mixed $bg_type
     */
    public function setBgType($bg_type)
    {
        $this->bg_type = $bg_type;
    }

    /**
     * @return mixed
     */
    public function getHeading()
    {
        return $this->heading_1;
    }

    /**
     * @param mixed $heading_1
     */
    public function setHeading($heading_1)
    {
        $this->heading_1 = $heading_1;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function toString(){
        return 'members';
    }



    public function setMember (Member $member){

    }


}