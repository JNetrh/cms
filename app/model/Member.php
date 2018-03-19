<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 13.3.2018
 * Time: 13:48
 */

namespace App\Model;

use Nette;


/**
 * Doctrine entita pro tabulku user.
 * @package App\Model
 * @ORM\Entity
 * @ORM\Table(name="members")
 */
class Member
{
//    public  $database;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\name(type="string")
     */
    private $name;
    /**
     * @ORM\name(type="text")
     */
    private $text;
    /**
     * @ORM\name(type="string")
     */
    private $image;
    /**
     * @ORM\name(type="bigint")
     */
    private $owner;
    /**
     * @ORM\name(type="tinyint")
     */
    private $active;


//    /**
//     * Members constructor.
//     * @param Nette\Database\Context $database
//     * @param $id
//     */
//    public function __construct(Nette\Database\Context $database)
//    {
//        $this->database = $database;
//    }


    public function initialize($id = -1){
        $this->id = $id;
        $this->setVariables($id);
    }


    public function setData($name, $text, $image, $owner, $active){
        $this->name = $name;
        $this->text = $text;
        $this->image = $image;
        $this->owner = $owner;
        $this->active = $active;
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
            'active' => $this->active
        ];
    }

    public function getFormProperties(){

        return [
            'id' => $this->id,
            'name' => $this->name,
            'text' => $this->text,
            'image' => $this->image,
            'owner' => $this->owner,
            'active' => $this->active
        ];
    }

    public function saveToDb(){
        if(isset($this->id)){
            $this->database->table('members')->where('id', $this->id)->update($this->databaseInput());
        }
        else{
            $this->database->table('members')->insert($this->databaseInput());
        }

    }


    /**
     * @param $id
     */
    private function setVariables($id){
        $dbOut = $this->database->table('members');

        if(count($dbOut) > 0){
            $dbOut = $dbOut->where('id', $id)->fetch();
            $this->setName($dbOut->name);
            $this->setText($dbOut->text);
            $this->setImage($dbOut->image);
            $this->setOwner($dbOut->owner);
            $this->setActive($dbOut->active);
        }


    }

    public function delete(){
        $toDelete = $this->database->table('members')->where('id', $this->getId())->fetch();
        if(file_exists($toDelete->image)){
            unlink($toDelete->image);
        }
        $toDelete->delete();
    }

    public function setDatabase($database){
        $this->database = $database;
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
            $newId =  $this->database->table('members')->where('name', $this->getName())->where('text', $this->getText())->where('active', $this->getActive())->get('id');
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




}