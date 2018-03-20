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
use App\Model\Entities\Reference;

/**
 * Doctrine entita
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="block_references")
 */
class BlockReferences
{


    use Identifier;

    /**
     * @ORM\OneToMany(targetEntity="Reference", mappedBy="ref")
     */
    private $references;



    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->references = new ArrayCollection();
    }


    public function getReferences(){
        return $this->references;
    }

    public function referencesCount() {
        return count($this->references);
    }

    /**
     * references name column
     * @ORM\Column(type="text")
     */
    protected $style;


    /**
     * references name column
     * @ORM\Column(type="string")
     */
    protected $bg_type;

    /**
     * references name column
     * @ORM\Column(type="string")
     */
    protected $heading;



    /**
     * references name column
     * @ORM\Column(type="string")
     */
    protected $image;



    /**
     * references name column
     * @ORM\Column(type="boolean")
     */
    protected $active;



    /**
     * references name column
     * @ORM\Column(type="integer")
     */
    protected $position;





    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'heading' => $this->getHeading(),
            'position' => $this->getPosition(),
            'active' => $this->getActive(),
            'image' => $this->getImage()
        ];
    }
    public function getColorProperties(){

        $style = json_decode($this->getStyle());


        return [
            'heading_color' => $style->heading_color,
            'text_color' => $style->text_color,
            'name_color' => $style->name_color,
            'background_color' => $style->background_color,
            'block_background_color' => $style->block_background_color
        ];
    }



    public function createEntity($name, $text, $image, $owner, $active, $reference)
    {
        $entity = new Reference();
        $entity->setName($name);
        $entity->setText($text);
        $entity->setImage($image);
        $entity->setOwner($owner);
        $entity->setActive($active);
        $entity->setReference($reference);

//        $this->references[] = $entity;

        return $entity;
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
        return $this->heading;
    }

    /**
     * @param mixed $heading
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
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
        return 'references';
    }





}