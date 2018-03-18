<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 13.3.2018
 * Time: 13:48
 */

namespace App\Model;

use Nette;
use App\Model\Member as Member;

class Headers  extends BaseBlock implements IBlock
{

    public $database;


    protected $table = 'block_header';


    private $heading_1;
    private $heading_2;
    private $button_1;
    private $button_1_link;
    private $button_2;
    private $button_2_link;


    /**
     * Members constructor.
     * @param Nette\Database\Context $database
     */
    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function setData($style, $bg_type, $heading_1, $heading_2, $button_1, $button_1_link, $button_2, $button_2_link, $image, $active, $position){
        $this->setStyle($style);
        $this->setBgType($bg_type);
        $this->heading_1 = $heading_1;
        $this->heading_2 = $heading_2;
        $this->button_1 = $button_1;
        $this->button_1_link = $button_1_link;
        $this->button_2 = $button_2;
        $this->button_2_link = $button_2_link;
        $this->setActive($active);
        $this->setPosition($position);
        $this->setImage($image);
    }


    /**
     * @return mixed
     */
    public function databaseInput(){
        return [
            'style' => $this->getStyle(),
            'bg_type' => $this->getBgType(),
            'heading_1' => $this->heading_1,
            'heading_2' => $this->heading_2,
            'button_1' => $this->button_1,
            'button_1_link' => $this->button_1_link,
            'button_2' => $this->button_2,
            'button_2_link' => $this->button_2_link,
            'active' => $this->getActive(),
            'position' => $this->getPosition(),
            'image' => $this->getImage()
        ];
    }

    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'heading_1' => $this->heading_1,
            'heading_2' => $this->heading_2,
            'button_1' => $this->button_1,
            'button_1_link' => $this->button_1_link,
            'button_2' => $this->button_2,
            'button_2_link' => $this->button_2_link,
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
     * @param $id
     */
    public function setVariables($id){
        $dbOut = $this->database->table($this->getTable());

        if(count($dbOut) > 0){
            $dbOut = $dbOut->where('id', $id)->fetch();

            $this->setStyle($dbOut->style);
            $this->setBgType($dbOut->bg_type);
            $this->setHeading1($dbOut->heading_1);
            $this->setHeading2($dbOut->heading_2);
            $this->setButton1($dbOut->button_1);
            $this->setButton1Link($dbOut->button_1_link);
            $this->setButton2($dbOut->button_2);
            $this->setButton2Link($dbOut->button_2_link);
            $this->setActive($dbOut->active);
            $this->setPosition($dbOut->position);
            $this->setImage($dbOut->image);
        }
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

    public function toString()
    {
        return "headers";
    }


}