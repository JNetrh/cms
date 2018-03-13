<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 13.3.2018
 * Time: 13:08
 */

namespace App\Model;

use Nette;
use App\Model\Members as Members;

class BlockFactory
{
    public $database;
    private $block_members;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
        $this->block_members = Nette\Utils\ArrayList();
    }


    /**
     * @return mixed
     */
    public function create(){

        $members = $this->database->table('block_members');

        foreach ($members as $member){
            $this->block_members[] = new Members($member['id']);
        }
    }

    /**
     * @return mixed
     */
    public function getBlockMembers()
    {
        return $this->block_members;
    }

    /**
     * @param mixed $block_members
     */
    public function setBlockMembers($block_members)
    {
        $this->block_members = $block_members;
    }




}