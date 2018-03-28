<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 13.3.2018
 * Time: 13:08
 */

namespace App\Model;

use Nette;
use App\Model\Services\ReferenceService;
use App\Model\Services\MemberService;
use App\Model\Services\HeaderService;
use App\Model\Services\EventService;
use App\Model\Services\ContactService;
use App\Model\Services\ArticleService;


class BlockFactory
{

    private $references;
    private $members;
    private $headers;
    private $events;
    private $contacts;
    private $articles;


    public function __construct(
        ReferenceService $references,
        MemberService $members,
        HeaderService $headers,
        EventService $events,
        ContactService $contacts,
        ArticleService $articles
    )
    {
        $this->references = $references;
        $this->members = $members;
        $this->headers = $headers;
        $this->events = $events;
        $this->contacts = $contacts;
        $this->articles = $articles;
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
     * @return mixed
     */
    public function getBlockReferences()
    {
        return $this->references;
    }

    /**
     * @return mixed
     */
    public function getBlockEvents()
    {
        return $this->events;
    }

    /**
     * @return mixed
     */
    public function getBlockContacts()
    {
        return $this->contacts;
    }

    /**
     * @return mixed
     */
    public function getBlockArticles()
    {
        return $this->articles;
    }


    public function getAllBlocks(){
        return $this->mergeBlocks();
    }

    private function mergeBlocks(){
        $merged = array_merge($this->getBlockMembers()->getEntities(), $this->getBlockHeader()->getEntities(), $this->getBlockReferences()->getEntities(), $this->getBlockEvents()->getEntities(), $this->getBlockContacts()->getEntities(), $this->getBlockArticles()->getEntities());

        usort($merged, function ($a, $b) {
            if($a->getPosition() == $b->getPosition()){ return 0 ; }
            return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
        });

        return $merged;
    }



}