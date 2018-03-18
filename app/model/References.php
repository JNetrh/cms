<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 13.3.2018
 * Time: 13:48
 */

namespace App\Model;

use Nette;
use App\Model\Reference as Reference;

class References extends BaseBlock implements IBlock
{

    public $database;

    protected $table = 'block_references';

    private $heading;
    private $references = [];


    /**
     * References constructor.
     * @param Nette\Database\Context $database
     */
    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }


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
            'heading' => $this->heading,
            'active' => $this->getActive(),
            'position' => $this->getPosition(),
            'image' => $this->getImage()
        ];
    }

    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'heading' => $this->heading,
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
            $this->setHeading($dbOut->heading);
            $this->setActive($dbOut->active);
            $this->setPosition($dbOut->position);
            $this->setImage($dbOut->image);

            $dbReferences = $this->database->table('referencese')->where('owner', $currId);

            if(count($dbReferences) > 0){
                foreach ($dbReferences as $dbReference){
                    $i = new Reference($this->database);
                    $i->initialize($dbReference->id);
                    $this->setReference($i);
                }
            }

        }
    }

    /**
     * @return mixed
     */
    public function referencesCount()
    {
        return count($this->references);
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
     * @return array
     */
    public function getReferences()
    {
        return $this->references;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getReferenceById($id){

        return $this->references[$id];
    }

    /**
     * @param $id
     * @param $ref reference to set with id
     */
    public function setReferenceById($id, $ref){
        $this->references[$id] = $ref;
    }

    /**
     * @param $reference to set
     */
    public function setReference($reference){
        $this->references[$reference->getId()] = $reference;
    }

    public function toString(){
        return "references";
    }



}