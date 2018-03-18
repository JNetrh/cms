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
use Nette\Caching\Cache;

class BlockFactory
{
    public $database;

    private $cache;

    private $block_members = [];
    private $block_header = [];
    private $block_references = [];

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;

        $storage = new Nette\Caching\Storages\FileStorage('../temp');
        $this->cache = new Cache($storage);



        $this->loadData();





    }


    private function loadData(){

        $value_members = $this->cache->load('members');
        $value_headers = $this->cache->load('headers');
        $value_references = $this->cache->load('references');

        if ($value_members === null or
            $value_headers === null or
            $value_references === null
        ){
            $members = $this->database->table('block_members');
            $headers = $this->database->table('block_header');
            $references = $this->database->table('block_references');

            foreach ($members as $member){
                $i = new Members($this->database);
                $i->initialize($member->id);

                $i->setDatabase(null);

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


            bdump($this->block_members);



            $this->cache->save('members', $this->block_members);
            $this->cache->save('headers', $this->block_header);
            $this->cache->save('references', $this->block_references);
        }
        else {

            $this->block_members = $this->cache->load('members');
            $this->block_header = $this->cache->load('headers');
            $this->block_references = $this->cache->load('references');

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


    public function getAllBlocks(){
        return $this->mergeBlocks();
    }

    private function mergeBlocks(){
        $merged = array_merge($this->block_members, $this->block_header, $this->block_references);

        $sorted = usort($merged, function ($a, $b) {
            if($a->getPosition() == $b->getPosition()){ return 0 ; }
            return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
        });

        return $merged;
    }




}