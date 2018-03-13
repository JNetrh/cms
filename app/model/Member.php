<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 13.3.2018
 * Time: 13:48
 */

namespace App\Model;

use Nette;

class Member
{
    public  $database;

    private $id;
    private $name;
    private $text;
    private $image;
    private $owner;


    /**
     * Members constructor.
     * @param Nette\Database\Context $database
     * @param $id
     */
    public function __construct(Nette\Database\Context $database, $id = -1)
    {
        $this->database = $database;
        $this->members = new Nette\Utils\ArrayList();
        $this->id = $id;
        $this->setVariables($id);
    }


    /**
     * @return mixed
     */
    public function databaseInput(){
        return [
            'name' => $this->name,
            'text' => $this->text,
            'image' => $this->image,
            'owner' => $this->owner
        ];
    }


    public function saveToDb(){
        $this->database->table('members')->where('id', $this->id)->update($this->databaseInput());
    }



    private function setVariables($id){
        $dbOut = $this->database->table('members')->where('id', $id);

        $this->setName($dbOut['name']);
        $this->setText($dbOut['text']);
        $this->setImage($dbOut['image']);
        $this->setOwner($dbOut['owner']);

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



}