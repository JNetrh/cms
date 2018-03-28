<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 17:40
 */

namespace App\Model\Entities;


use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * Doctrine entita
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="block_contacts")
 */
class BlockContacts
{


    use Identifier;

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
    protected $heading_1;

    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $heading_2;

    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $image;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $email;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $phone;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $adress;


    /**
     * right name column
     * @ORM\Column(type="float")
     */
    protected $gpsx;


    /**
     * right name column
     * @ORM\Column(type="float")
     */
    protected $gpsy;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $instagram;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $facebook;


    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $twitter;



    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $linkedin;


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
     * @return array of form properties
     */
    public function getFormProperties(){

        return [
            'id' => $this->getId(),
            'heading_1' => $this->getHeading1(),
            'heading_2' => $this->getHeading2(),
            'position' => $this->getPosition(),
            'active' => $this->getActive(),
            'image' => $this->getImage(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'adress' => $this->getAdress(),
            'gpsx' => $this->getGpsx(),
            'gpsy' => $this->getGpsy(),
            'facebook' => $this->getFacebook(),
            'twitter' => $this->getTwitter(),
            'instagram' => $this->getInstagram(),
            'linkedin' => $this->getLinkedin(),
        ];
    }

    /**
     * @return array of colors dedicated to the block
     */
    public function getColorProperties(){

        $style = json_decode($this->getStyle());


        return [
            'heading_1_color' => $style->heading_1_color,
            'heading_2_color' => $style->heading_2_color,
            'text_color' => $style->text_color,
            'background_color' => $style->background_color,
            'block_background_color' => $style->block_background_color
        ];
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
     * @return mixed
     */
    public function getHeading1()
    {
        return $this->heading_1;
    }

    /**
     * @param mixed $heading_1
     */
    public function setHeading1($heading_1)
    {
        $this->heading_1 = $heading_1;
    }

    /**
     * @return mixed
     */
    public function getHeading2()
    {
        return $this->heading_2;
    }

    /**
     * @param mixed $heading_2
     */
    public function setHeading2($heading_2)
    {
        $this->heading_2 = $heading_2;
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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        if(file_exists($this->getImage())){
            unlink($this->getImage());
        }
        $this->image = $image;
    }


    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param string $adress
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
    }

    /**
     * @return double
     */
    public function getGpsx()
    {
        return $this->gpsx;
    }

    /**
     * @param mixed $gpsx
     */
    public function setGpsx($gpsx)
    {
        $this->gpsx = $gpsx;
    }

    /**
     * @return mixed
     */
    public function getGpsy()
    {
        return $this->gpsy;
    }

    /**
     * @param mixed $gpsy
     */
    public function setGpsy($gpsy)
    {
        $this->gpsy = $gpsy;
    }

    /**
     * @return mixed
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * @param mixed $instagram
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;
    }

    /**
     * @return mixed
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param mixed $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return mixed
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param mixed $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @return mixed
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * @param mixed $linkedin
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;
    }

    /**
     * @return string
     */
    public function toString(){
        return 'contacts';
    }


}