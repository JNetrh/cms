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
use App\Model\Entities\Sponsor;

/**
 * Doctrine entita
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="block_sponsors")
 */
class BlockSponsors
{


    use Identifier;

    /**
     * @ORM\OneToMany(targetEntity="Sponsor", mappedBy="ref")
     */
    private $sponsors;


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
     * @ORM\Column(type="boolean")
     */
    protected $active;



    /**
     * right name column
     * @ORM\Column(type="integer")
     */
    protected $position;


    /**
     * @return array of form properties
     */
    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'heading' => $this->getHeading(),
            'active' => $this->getActive(),
            'position' => $this->getPosition(),
            'image' => $this->getImage()
        ];
    }

    /**
     * @return array of colors dedicated to the block
     */
    public function getColorProperties(){

        $style = json_decode($this->getStyle());


//        return [
//            'heading_color' => $style->heading_color,
//            'background_color' => $style->background_color,
//            'block_background_color' => $style->block_background_color
//        ];

	    return (array)$style;
    }

    /**
     * @return integer
     */
    public function sponsorsCount()
    {
        return count($this->sponsors);
    }

    /**
     * Deletes image from server
     */
    public function deleteImage(){
        $this->setImage(null);
    }

    /**
     * @param $id of the searching sponsor block
     * @return Sponsor
     */
    public function findById($id){
        foreach ($this->sponsors as $el){
            if($el->getId() == $id){
                return $el;
            }
        }
    }


    /**
     * set the sponsor dedicated to this block
     * @param \App\Model\Entities\Sponsor $sponsor
     */
    public function setSponsor (Sponsor $sponsor){
        $this->sponsors->add($sponsor);
    }

    /**
     * remove sponsor dedicated to this block and returns it back
     * @param \App\Model\Entities\Sponsor $sponsor
     * @return \App\Model\Entities\Sponsor
     */
    public function removeSponsor(Sponsor $sponsor){
        $this->sponsors->remove($sponsor->getId());
        return $sponsor;
    }

    /**
     * @return string
     */
    public function getSponsors()
    {
        return $this->sponsors;
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
        return 'sponsors';
    }







}