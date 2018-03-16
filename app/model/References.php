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

class References
{

    public $database;

    private $id;
    private $style;
    private $bg_type;
    private $heading;
    private $active;
    private $position;
    private $image;
    private $references = [];


    /**
     * References constructor.
     * @param Nette\Database\Context $database
     */
    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    /**
     * @param int $id
     */
    public function initialize($id = -1){
        $this->id = $id;
        $this->setVariables($id);
    }

    public function setData($style, $bg_type, $heading, $active, $position, $image){
        $this->style = $style;
        $this->bg_type = $bg_type;
        $this->heading = $heading;
        $this->active = $active;
        $this->position = $position;
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function databaseInput(){
        return [
            'style' => $this->style,
            'bg_type' => $this->bg_type,
            'heading' => $this->heading,
            'active' => $this->active,
            'position' => $this->position,
            'image' => $this->image
        ];
    }

    public function getFormProperties(){

        return [
            'id' => $this->id,
            'heading' => $this->heading,
            'position' => $this->position,
            'active' => $this->active,
            'image' => $this->image
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


    public function saveToDb(){

        if(isset($this->id)){
            $this->database->table('block_references')->where('id', $this->id)->update($this->databaseInput());
        }
        else{
            $this->database->table('block_references')->insert($this->databaseInput());
        }

    }

    public function delete(){
        foreach ($this->getReferences() as $reference){
            $reference->delete();
        }
        $toDelete = $this->database->table('block_references')->where('id', $this->id)->fetch();
        if(file_exists($toDelete->image)){
            unlink($toDelete->image);
        }
        $toDelete->delete();
    }

    /**
     * @param $id
     */
    private function setVariables($id){
        $dbOut = $this->database->table('block_references');

        if(count($dbOut) > 0){
            $dbOut = $dbOut->where('id', $id)->fetch();
            $this->setStyle($dbOut->style);
            $this->setBgType($dbOut->bg_type);
            $this->setHeading($dbOut->heading);
            $this->setActive($dbOut->active);
            $this->setPosition($dbOut->position);
            $this->setImage($dbOut->image);

            $dbReferences = $this->database->table('referencese')->where('owner', $this->id);

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
    public function getId()
    {
        if(isset($this->id)){
            return $this->id;
        }
        else{
            $newId =  $this->database->table('block_references')->where('style', $this->getStyle())->where('bg_type', $this->getBgType())->where('heading', $this->getHeading())->get('id');
            $this->setId($newId);
            return $newId;
        }
    }

    /**
     * @param mixed $id
     */
    private function setId($id)
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



}