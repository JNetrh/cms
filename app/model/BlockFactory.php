<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 13.3.2018
 * Time: 13:08
 */

namespace App\Model;

use Nette;
//use App\Model\Members as Members;
//use App\Model\Headers as Headers;
//use App\Model\References as References;
//use Nette\Caching\Cache;



use App\Model\Services\ReferenceService;
use App\Model\Services\MemberService;
use App\Model\Services\HeaderService;


class BlockFactory
{
//    public $database;
//
//    private $cache;
//
//    private $block_members = [];
//    private $block_header = [];
//    private $block_references = [];


    private $references;
    private $members;
    private $headers;


    public function __construct(ReferenceService $references, MemberService $members, HeaderService $headers)
    {
//        $this->database = $database;

//        $storage = new Nette\Caching\Storages\FileStorage('../temp');
//        $this->cache = new Cache($storage);



        // TODO: tohle už vrací pole, musí to bejt bez toho getteru!!!
        $this->references = $references;
        $this->members = $members;
        $this->headers = $headers;



//        $this->loadData();





    }



    /**
     * @return mixed
     */
    public function getBlockMembers()
    {
        return $this->members;
    }


    /**
     * @return mixed
     */
    public function getBlockHeader()
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getBlockReferences()
    {
        return $this->references;
    }


    public function getAllBlocks(){
        return $this->mergeBlocks();
    }

    private function mergeBlocks(){
        $merged = array_merge($this->getBlockMembers()->getEntities(), $this->getBlockHeader()->getEntities(), $this->getBlockReferences()->getEntities());

        usort($merged, function ($a, $b) {
            if($a->getPosition() == $b->getPosition()){ return 0 ; }
            return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
        });

        return $merged;
    }




}