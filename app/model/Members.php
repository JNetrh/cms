<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 13.3.2018
 * Time: 13:48
 */

namespace App\Model;

use Nette;
use App\Model\Member as member;

class Members
{
    public  $database;

    private $id;
    private $style;
    private $bg_type;
    private $heading;
    private $active;
    private $position;
    private $image;
    private $members;


    /**
     * Members constructor.
     * @param Nette\Database\Context $database
     * @param $id
     */
    public function __construct(Nette\Database\Context $database, $id = -1, blockBuilder $blockBuilder)
    {
        $this->database = $database;
        $this->members = $blockBuilder->getBlockMembers();
        $this->id = $id;
        $this->setVariables($id);
    }


    /**
     * @return mixed
     */
    public function databaseInput(){
        return [
            'style' => $this->style,
            'bg_type' => $this->bg_type,
            'heading_1' => $this->heading,
            'active' => $this->active,
            'position' => $this->position,
            'image' => $this->image
        ];
    }


    public function saveToDb(){
        $this->database->table('block_members')->where('id', $this->id)->update($this->databaseInput());
    }

    private function setVariables($id){
        $dbOut = $this->database->table('block_members')->where('id', $id);

        $this->setStyle($dbOut['style']);
        $this->setBgType($dbOut['bg_type']);
        $this->setHeading($dbOut['heading_1']);
        $this->setActive($dbOut['active']);
        $this->setPosition($dbOut['position']);
        $this->setImage($dbOut['image']);

        $dbMembers = $this->database->table('members')->where('owner', $this->id);

        foreach ($dbMembers as $dbMember){
            $this->setMember(new member($dbMember['id']));
        }

    }


    public function setMember(member $member){
        $this->members[] = $member;
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
     * @return Nette\Utils\ArrayList
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param Nette\Utils\ArrayList $members
     */
    public function setMembers($members)
    {
        $this->members = $members;
    }




}