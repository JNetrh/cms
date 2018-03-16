<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 13.3.2018
 * Time: 13:48
 */

namespace App\Model;

use Nette;

class Reference
{
    public  $database;

    private $id;
    private $name;
    private $text;
    private $image;
    private $owner;
    private $active;
    private $reference;


    /**
     * Reference constructor.
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


    /**
     * @param $name
     * @param $text
     * @param $image
     * @param $owner
     * @param $active
     * @param $reference
     */
    public function setData($name, $text, $image, $owner, $active, $reference){
        $this->name = $name;
        $this->text = $text;
        $this->image = $image;
        $this->owner = $owner;
        $this->active = $active;
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function databaseInput(){
        return [
            'name' => $this->name,
            'text' => $this->text,
            'image' => $this->image,
            'owner' => $this->owner,
            'active' => $this->active,
            'reference' => $this->reference
        ];
    }

    public function getFormProperties(){

        return [
            'id' => $this->id,
            'name' => $this->name,
            'text' => $this->text,
            'image' => $this->image,
            'owner' => $this->owner,
            'active' => $this->active,
            'reference' => $this->reference
        ];
    }

    public function saveToDb(){
        if(isset($this->id)){
            $this->database->table('referencese')->where('id', $this->id)->update($this->databaseInput());
        }
        else{
            $this->database->table('referencese')->insert($this->databaseInput());
        }

    }


    /**
     * @param $id
     */
    private function setVariables($id){
        $dbOut = $this->database->table('referencese');

        if(count($dbOut) > 0){
            $dbOut = $dbOut->where('id', $id)->fetch();
            $this->setName($dbOut->name);
            $this->setText($dbOut->text);
            $this->setImage($dbOut->image);
            $this->setOwner($dbOut->owner);
            $this->setActive($dbOut->active);
            $this->setReference($dbOut->reference);
        }


    }

    public function delete(){
        $toDelete = $this->database->table('referencese')->where('id', $this->getId())->fetch();
        if(file_exists($toDelete->image)){
            unlink($toDelete->image);
        }
        $toDelete->delete();
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
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
            $newId =  $this->database->table('referencese')->where('name', $this->getName())->where('text', $this->getText())->where('active', $this->getActive())->where('reference', $this->getReference())->get('id');
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }





}