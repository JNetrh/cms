<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 21.3.2018
 * Time: 18:17
 */

namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use App\Model\Entities\BlockEvents;

/**
 * Doctrine entita
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="events")
 */
class Event
{


    use Identifier;



    /**
     * @ORM\ManyToOne(targetEntity="BlockEvents", inversedBy="events")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id", onDelete="CASCADE")
     */
    private $ref;

    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $heading;

    /**
     * right name column
     * @ORM\Column(type="datetime")
     */
    protected $event_time;


    /**
     * right name column
     * @ORM\Column(type="text")
     */
    protected $text;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $link;



    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $image;


    /**
     * right name column
     * @ORM\Column(type="integer")
     */
    protected $owner;


    /**
     * right name column
     * @ORM\Column(type="boolean")
     */
    protected $active;


    /**
     * right name column
     * @ORM\Column(type="boolean")
     */
    protected $position;


    /**
     * deletes image that corresponds with this subBlock
     */
    public function deleteImage(){
        if(is_file($this->getImage())){
            unlink($this->getImage());
        }
        $this->setImage(null);
    }


    /**
     * @return array of default form properties
     */
    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'heading' => $this->getHeading(),
            'event_time' => $this->getEventTime()->format('d/m/Y'),
            'text' => $this->getText(),
            'link' => $this->getLink(),
            'image' => $this->getImage(),
            'position' => $this->getPosition(),
            'owner' => $this->getOwner(),
            'active' => $this->getActive()
        ];
    }




    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return BlockEvents
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param BlockEvents $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * @return string
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param string $heading
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
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
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param BlockEvents $owner
     */
    public function setOwner(BlockEvents $owner)
    {
        $this->owner = $owner->getId();
        $this->setRef($owner);
    }

    /**
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getEventTime()
    {
        return $this->event_time;
    }

    /**
     * @param mixed $event_time
     */
    public function setEventTime($event_time)
    {
        $this->event_time = $event_time;
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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }







}