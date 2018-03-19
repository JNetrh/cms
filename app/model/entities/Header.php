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
 * @ORM\Table(name="block_header")
 */
class Header
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
    protected $button_1;



    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $button_2;



    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $button_1_link;



    /**
     * right name column
     * @ORM\Column(type="string")
     */
    protected $button_2_link;



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
}