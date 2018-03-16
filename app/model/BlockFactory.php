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
use App\Model\Headers as Headers;
use App\Model\References as References;

class BlockFactory
{
    public $database;
    private $block_members = [];
    private $block_header = [];
    private $block_references = [];

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;


        $members = $this->database->table('block_members');
        $headers = $this->database->table('block_header');
        $references = $this->database->table('block_references');

        foreach ($members as $member){
            $i = new Members($this->database);
            $i->initialize($member->id);
            $this->block_members[$member->id] = $i;
        }


        foreach ($headers as $header){
            $i = new Headers($this->database);
            $i->initialize($header->id);
            $this->block_header[$header->id] = $i;
        }


        foreach ($references as $reference){
            $i = new References($this->database);
            $i->initialize($reference->id);
            $this->block_references[$reference->id] = $i;
        }

        bdump($this->mergeBlocks());

    }


    /**
     * @return mixed
     */
    public function getBlockMembers()
    {
        return $this->block_members;
    }


    /**
     * @return mixed
     */
    public function getBlockHeader()
    {
        return $this->block_header;
    }

    /**
     * @return array
     */
    public function getBlockReferences()
    {
        return $this->block_references;
    }


    private function mergeBlocks(){
        $merged = array_merge($this->block_members, $this->block_header, $this->block_references);

        $sorted = usort($merged, function ($a, $b) {
            if($a->getPosition() == $b->getPosition()){ return 0 ; }
            return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
        });

        bdump($merged);
    }

//    private function sort_objects_by_total($a, $b) {
//        if($a->position == $b->position){ return 0 ; }
//        return ($a->position < $b->position) ? -1 : 1;
//    }




}