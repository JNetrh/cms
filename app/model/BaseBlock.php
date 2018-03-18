<?php
/**
 * Created by PhpStorm.
 * User: jakub
 * Date: 17/03/2018
 * Time: 16:36
 */

namespace App\Model;

use Nette;


abstract class BaseBlock
{

    private $id = null;
    private $style;
    private $bg_type;
    private $image;
    private $active;
    private $position;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }


    public function initialize($id = -1){
        $this->setId($id);
        $this->setVariables($id);
    }


    public function saveToDb(){
        $currId = $this->getId();
        if(is_int($currId)){
            $this->database->table($this->getTable())->where('id', $currId)->update($this->databaseInput());
            bdump(is_int($currId), 'currID');
        }
        else{
            $this->database->table($this->getTable())->insert($this->databaseInput());
        }

    }

    public function delete(){
        $currId = $this->getId();
        foreach ($this->getReferences() as $reference){
            $reference->delete();
        }
        $toDelete = $this->database->table($this->getTable())->where('id', $currId)->fetch();
        if(file_exists($toDelete->image)){
            unlink($toDelete->image);
        }
        $toDelete->delete();
    }


    public function setId($id){
        $this->id = $id;
    }


    public function setDatabase($database){
        $this->database = $database;
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
    public function getId()
    {
        $currId = $this->id;
        if(is_int($currId)){
            return $currId;
        }
        else{
            $newId =  $this->database->table($this->getTable())->where('style', $this->getStyle())->where('bg_type', $this->getBgType())->where('active', $this->getActive())->get('id');
            $this->setId($newId);
            return $newId;
        }
    }




    public function deleteImage() {
        $image = $this->database->table($this->getTable())->where('id', $this->getId());
        if(file_exists($image->get('image'))){
            unlink($image);
        }
        $image->update(['image' => ""]);
    }

    public function getTable(){
        return $this->table;
    }


}