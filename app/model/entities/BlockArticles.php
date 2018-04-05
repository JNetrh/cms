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
 * @ORM\Table(name="block_articles")
 */
class BlockArticles
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
     * @ORM\Column(type="text")
     */
    protected $text;



    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $image_article;



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
            'heading_1' => $this->getHeading1(),
            'heading_2' => $this->getHeading2(),
            'text' => $this->getText(),
            'image_article' => $this->getImageArticle(),
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


        return [
            'heading_1_color' => $style->heading_1_color,
            'heading_2_color' => $style->heading_2_color,
            'text_color' => $style->text_color,
            'background_color' => $style->background_color
        ];
    }

    /**
     * Deletes image from server
     */
    public function deleteImage(){
        $this->setImage(null);
    }

    /**
     * Deletes article image from server
     */
    public function deleteImageArticle(){
        $this->setImageArticle(null);
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
    public function getHeading1()
    {
        return $this->heading_1;
    }

    /**
     * @param string $heading_1
     */
    public function setHeading1($heading_1)
    {
        $this->heading_1 = $heading_1;
    }

    /**
     * @return string
     */
    public function getHeading2()
    {
        return $this->heading_2;
    }

    /**
     * @param string $heading_2
     */
    public function setHeading2($heading_2)
    {
        $this->heading_2 = $heading_2;
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
     * @return mixed
     */
    public function getImageArticle()
    {
        return $this->image_article;
    }

    /**
     * @param mixed $image_article
     */
    public function setImageArticle($image_article)
    {
        if(file_exists($this->getImageArticle())){
            unlink($this->getImageArticle());
        }
        $this->image_article = $image_article;
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
	 * @return string
	 */
	public function getMainHeading(){
		return $this->getHeading1();
	}

    /**
     * @return string
     */
    public function toString(){
        return 'articles';
    }







}