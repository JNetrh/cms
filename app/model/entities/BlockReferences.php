<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 18.3.2018
 * Time: 17:39
 */

namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * Doctrine entita
 * @package App\Model\Entities
 * @ORM\Entity
 * @ORM\Table(name="block_references")
 */
class BlockReferences
{


    use Identifier;

//    /**
//     * @var Collection
//     * @ORM\OneToMany(targetEntity="Reference", mappedBy="owner")
//     */
    /**
     * @ORM\OneToMany(targetEntity="Reference", mappedBy="ref")
     */
    private $refs;



    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->refs = new ArrayCollection();
    }


    public function getReferences(){
        return $this->refs;
    }

    /**
     * references name column
     * @ORM\Column(type="text")
     */
    protected $style;


    /**
     * references name column
     * @ORM\Column(type="string")
     */
    protected $bg_type;

    /**
     * references name column
     * @ORM\Column(type="string")
     */
    protected $heading;



    /**
     * references name column
     * @ORM\Column(type="string")
     */
    protected $image;



    /**
     * references name column
     * @ORM\Column(type="boolean")
     */
    protected $active;



    /**
     * references name column
     * @ORM\Column(type="integer")
     */
    protected $position;
}