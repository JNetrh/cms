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
use App\Model\Services\SponsorService;


class BlockFactory
{

    private $references;
    private $members;
    private $headers;
    private $events;
    private $contacts;
    private $articles;
    private $sponsors;


    public function __construct(
        ReferenceService $references,
        MemberService $members,
        HeaderService $headers,
        EventService $events,
        ContactService $contacts,
        ArticleService $articles,
        SponsorService $sponsors
    )
    {
        $this->references = $references;
        $this->members = $members;
        $this->headers = $headers;
        $this->events = $events;
        $this->contacts = $contacts;
        $this->articles = $articles;
        $this->sponsors = $sponsors;
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

    /**
     * @return mixed
     */
    public function getBlockSponsors()
    {
        return $this->sponsors;
    }


    public function getAllBlocks(){
        return $this->mergeBlocks();
    }

    private function mergeBlocks(){
        $merged = array_merge($this->getBlockMembers()->getEntities(), $this->getBlockHeader()->getEntities(), $this->getBlockReferences()->getEntities(), $this->getBlockEvents()->getEntities(), $this->getBlockContacts()->getEntities(), $this->getBlockArticles()->getEntities(), $this->getBlockSponsors()->getEntities());

        usort($merged, function ($a, $b) {
            if($a->getPosition() == $b->getPosition()){ return 0 ; }
            return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
        });

        return $merged;
    }



}