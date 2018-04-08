<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 21.3.2018
 * Time: 18:18
 */

namespace App\Model\Entities;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use App\Model\Entities\Event;

/**
 * Doctrine entita
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="block_events")
 */
class BlockEvents
{


    use Identifier;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="ref")
     */
    private $events;

    /**
     * right name column
     * @ORM\Column(type="text")
     */
    protected $style;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $bg_type;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $heading;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $image;


    /**
     * right name column
     * @ORM\Column(type="boolean")
     */
    protected $active;


    /**
     * right name column
     * @ORM\Column(type="integer")
     */
    protected $position;


    /**
     * BlockEvents constructor, initializes collections
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }


    /**
     * @return array of form properties
     */
    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'heading' => $this->getHeading(),
            'position' => $this->getPosition(),
            'active' => $this->getActive(),
            'image' => $this->getImage()
        ];
    }

    /**
     * @return array of colors dedicated to the block
     */
    public function getColorProperties(){

        $style = json_decode($this->getStyle());


//        return [
//            'heading_color' => $style->heading_color,
//            'text_color' => $style->text_color,
//            'time_color' => $style->time_color,
//            'background_color' => $style->background_color,
//            'block_background_color' => $style->block_background_color
//        ];
	    return (array)$style;
    }


    /**
     * @param $name
     * @param $text
     * @param $eventTime
     * @param $image
     * @param $owner
     * @param $active
     * @return \App\Model\Entities\Event
     */
    public function createEntity($name, $text, $eventTime, $image, $owner, $active)
    {
        $entity = new Event();
        $entity->setHeading($name);
        $entity->setText($text);
        $entity->setEventTime($eventTime);
        $entity->setImage($image);
        $entity->setOwner($owner);
        $entity->setActive($active);

//        $this->events[] = $entity;

        return $entity;
    }

    /**
     * @return integer
     */
    public function eventsCount()
    {
        return count($this->events);
    }

    /**
     * Deletes image from server
     */
    public function deleteImage(){
        if(file_exists($this->getImage())){
            unlink($this->getImage());
        }
        $this->setImage(null);
    }

    /**
     * @param $id of the searching event block
     * @return Event
     */
    public function findById($id){
        foreach ($this->events as $el){
            if($el->getId() == $id){
                return $el;
            }
        }
    }


    /**
     * set the event dedicated to this block
     * @param \App\Model\Entities\Event $event
     */
    public function setEvent (Event $event){
        $this->events->add($event);
    }

    /**
     * remove event dedicated to this block and returns it back
     * @param \App\Model\Entities\Event $event
     * @return \App\Model\Entities\Event
     */
    public function removeEvent(Event $event){
        $this->events->remove($event->getId());
        return $event;
    }

    /**
     * @return string
     */
    public function getEvents()
    {
	    $sort = $this->events;

	    $iterator = $sort->getIterator();
	    $iterator->uasort(function ($a, $b) {
		    return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
	    });
	    $sort = new ArrayCollection(iterator_to_array($iterator));

	   	return $sort;
    }


    /**
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param string $style
     */
    public function setStyle($style)
    {
        $this->style = $style;
    }

    /**
     * @return string
     */
    public function getBgType()
    {
        return $this->bg_type;
    }

    /**
     * @param string $bg_type
     */
    public function setBgType($bg_type)
    {
        $this->bg_type = $bg_type;
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
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param integer $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param integer $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

	/**
	 * @return string
	 */
	public function getMainHeading(){
		return $this->getHeading();
	}

    /**
     * @return string
     */
    public function toString(){
        return 'events';
    }


}