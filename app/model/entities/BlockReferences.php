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



    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->references = new ArrayCollection();
    }

    /**
     * @return array of form properties
     */
    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'heading' => $this->getHeading(),
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
            'heading_color' => $style->heading_color,
            'text_color' => $style->text_color,
            'name_color' => $style->name_color,
            'background_color' => $style->background_color,
            'block_background_color' => $style->block_background_color
        ];
    }


    /**
     * @param $name
     * @param $text
     * @param $image
     * @param $owner
     * @param $active
     * @param $reference
     * @return \App\Model\Entities\Reference
     */
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
     * @return integer
     */
    public function referencesCount()
    {
        return count($this->references);
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
     * @param $id of the Block
     * @return BlockReferences
     */
    public function findById($id){
        foreach ($this->references as $el){
            if($el->getId() == $id){
                return $el;
            }
        }
    }


    /**
     * set the reference dedicated to this block
     * @param \App\Model\Entities\Reference $reference
     */
    public function setReference (Reference $reference){
        $this->references->add($reference);
    }

    /**
     * remove reference dedicated to this block and returns it back
     * @param \App\Model\Entities\Reference $reference
     * @return \App\Model\Entities\Reference
     */
    public function removeReference(Reference $reference){
        $this->references->remove($reference->getId());
        return $reference;
    }

    /**
     * return all references dedicated to this block
     * @return mixed
     */
    public function getReferences()
    {
        return $this->references;
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
    public function toString(){
        return 'references';
    }





}