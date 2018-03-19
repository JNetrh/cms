<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 17:40
 */

namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Doctrine entita
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="members")
 */
class Member
{


    /**
     * Id column
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;


    /**
     * right name column
     * @ORM\Column(type="text")
     */
    protected $name;


    /**
     * right name column
     * @ORM\Column(type="text")
     */
    protected $text;



    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $image;


    /**
     * right name column
     * @ORM\Column(type="tinyint")
     */
    protected $owner;



    /**
     * right name column
     * @ORM\Column(type="boolean")
     */
    protected $active;




}