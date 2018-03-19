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
 * @ORM\Table(name="referencese")
 */
class Reference
{


   use Identifier;




//    /**
//     *
//     * @ORM\ManyToOne(targetEntity="References", inversedBy="refs")
//     *
//     */
//    protected $owner;

    /**
     * @ORM\ManyToOne(targetEntity="BlockReferences", inversedBy="refs")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id")
     */
    private $ref;


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


//    /**
//     * right name column
//     * @ORM\Column(type="integer")
//     */
//    protected $owner;



    /**
     * right name column
     * @ORM\Column(type="boolean")
     */
    protected $active;


    /**
     * right name column
     * @ORM\Column(type="text")
     */
    protected $reference;




}