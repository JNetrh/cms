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
 * @ORM\Table(name="block_header")
 */
class BlockHeader
{


    use Identifier;


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
    protected $heading_2;



    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $button_1;



    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $button_2;



    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $button_1_link;



    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $button_2_link;



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
            'heading_1' => $this->getHeading1(),
            'heading_2' => $this->getHeading2(),
            'button_1' => $this->getButton1(),
            'button_1_link' => $this->getButton1Link(),
            'button_2' => $this->getButton2(),
            'button_2_link' => $this->getButton2Link(),
            'active' => $this->getActive(),
            'position' => $this->getPosition(),
            'image' => $this->getImage()
        ];
    }
    public function getColorProperties(){

        $style = json_decode($this->getStyle());


        return [
            'heading_1_color' => $style->heading_1_color,
            'heading_2_color' => $style->heading_2_color,
            'button_1_color' => $style->button_1_color,
            'button_1_border_color' => $style->button_1_border,
            'button_1_background_color' => $style->button_1_background,
            'button_2_color' => $style->button_2_color,
            'button_2_border_color' => $style->button_2_border,
            'button_2_background_color' => $style->button_2_background,
            'background_color' => $style->background_color
        ];
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
    public function getHeading1()
    {
        return $this->heading_1;
    }

    /**
     * @param mixed $heading_1
     */
    public function setHeading1($heading_1)
    {
        $this->heading_1 = $heading_1;
    }

    /**
     * @return mixed
     */
    public function getHeading2()
    {
        return $this->heading_2;
    }

    /**
     * @param mixed $heading_2
     */
    public function setHeading2($heading_2)
    {
        $this->heading_2 = $heading_2;
    }

    /**
     * @return mixed
     */
    public function getButton1()
    {
        return $this->button_1;
    }

    /**
     * @param mixed $button_1
     */
    public function setButton1($button_1)
    {
        $this->button_1 = $button_1;
    }

    /**
     * @return mixed
     */
    public function getButton2()
    {
        return $this->button_2;
    }

    /**
     * @param mixed $button_2
     */
    public function setButton2($button_2)
    {
        $this->button_2 = $button_2;
    }

    /**
     * @return mixed
     */
    public function getButton1Link()
    {
        return $this->button_1_link;
    }

    /**
     * @param mixed $button_1_link
     */
    public function setButton1Link($button_1_link)
    {
        $this->button_1_link = $button_1_link;
    }

    /**
     * @return mixed
     */
    public function getButton2Link()
    {
        return $this->button_2_link;
    }

    /**
     * @param mixed $button_2_link
     */
    public function setButton2Link($button_2_link)
    {
        $this->button_2_link = $button_2_link;
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
        return 'headers';
    }







}