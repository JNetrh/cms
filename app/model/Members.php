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

class Members extends BaseBlock implements IBlock
{

    /** @var Nette\Database\Context @inject */
    public $database;

    protected $table = 'block_members';

    private $heading;
    private $members = [];


//    /**
//     * Members constructor.
//     * @param Nette\Database\Context $database
//     */
//    public function __construct(Nette\Database\Context $database)
//    {
//        $this->database = $database;
//    }


    public function setData($style, $bg_type, $heading, $active, $position, $image){
        $this->setStyle($style);
        $this->setBgType($bg_type);
        $this->heading = $heading;
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
            'heading_1' => $this->heading,
            'active' => $this->getActive(),
            'position' => $this->getPosition(),
            'image' => $this->getImage()
        ];
    }

    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'heading_1' => $this->heading,
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


    /**
     * @param $id
     */
    public function setVariables($id){
        $dbOut = $this->database->table($this->getTable());
        $currId = $this->getId();
        if(count($dbOut) > 0){
            $dbOut = $dbOut->where('id', $id)->fetch();
            $this->setStyle($dbOut->style);
            $this->setBgType($dbOut->bg_type);
            $this->setHeading($dbOut->heading_1);
            $this->setActive($dbOut->active);
            $this->setPosition($dbOut->position);
            $this->setImage($dbOut->image);

            $dbMembers = $this->database->table('members')->where('owner', $currId);

            if(count($dbMembers) > 0){
                foreach ($dbMembers as $dbMember){
                    $i = new Member($this->database);
                    $i->initialize($dbMember->id);

                    $i->setDatabase(null);

                    $this->setMember($i);
                }
            }

        }
    }


    public function setMember(Member $member){
        $this->members[$member->getId()] = $member;
    }

    /**
     * @return mixed
     */
    public function membersCount()
    {
        return count($this->members);
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
     * @return Nette\Utils\ArrayList
     */
    public function getMembers()
    {
        return $this->members;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getMemberById($id){
        return $this->members[$id];
    }

    /**
     * @param Nette\Utils\ArrayList $members
     */
    public function setMembers($members)
    {
        $this->members = $members;
    }

    public function toString()
    {
        return "members";
    }


}