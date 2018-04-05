<?php

namespace App\AdminModule\Presenters;

use Nette;
use App\Model\BlockFactory as BF;

class SummaryPresenter extends SecuredBasePresenter {


    private $members;
    private $headers;
    private $references;
    private $events;
    private $contacts;
    private $articles;
    private $sponsors;
    private $myBlocks;



    public function __construct(BF $blockFactory)
    {
        $this->members = $blockFactory->getBlockMembers();
        $this->headers = $blockFactory->getBlockHeader();
        $this->references = $blockFactory->getBlockReferences();
        $this->events = $blockFactory->getBlockEvents();
        $this->contacts = $blockFactory->getBlockContacts();
        $this->articles = $blockFactory->getBlockArticles();
        $this->sponsors = $blockFactory->getBlockSponsors();

        $this->myBlocks = $blockFactory;
    }


    public function renderDefault(){
        $this->template->members = $this->members->getEntities();
        $this->template->headers = $this->headers->getEntities();
        $this->template->references = $this->references->getEntities();
        $this->template->events = $this->events->getEntities();
        $this->template->contacts = $this->contacts->getEntities();
        $this->template->articles = $this->articles->getEntities();
        $this->template->sponsors = $this->sponsors->getEntities();

        $this->template->myBlocks = $this->myBlocks->getAllBlocks();
    }


    public function handleDeleteMember($blockId){
    	$this->deleteMenu($this->members->findById($blockId));
        $this->members->delete($blockId);
        $this->redirect('Summary:');
    }

    public function handleDeleteHeader($blockId){
        $this->headers->delete($blockId);
        $this->redirect('Summary:');
    }

    public function handleDeleteReference($blockId){
	    $this->deleteMenu($this->references->findById($blockId));
        $this->references->delete($blockId);
        $this->redirect('Summary:');
    }

    public function handleDeleteEvent($blockId){
	    $this->deleteMenu($this->events->findById($blockId));
        $this->events->delete($blockId);
        $this->redirect('Summary:');
    }

    public function handleDeleteContact($blockId){
	    $this->deleteMenu($this->contacts->findById($blockId));
        $this->contacts->delete($blockId);
        $this->redirect('Summary:');
    }

    public function handleDeleteArticle($blockId){
	    $this->deleteMenu($this->articles->findById($blockId));
        $this->articles->delete($blockId);
        $this->redirect('Summary:');
    }

    public function handleDeleteSponsor($blockId){
	    $this->deleteMenu($this->sponsors->findById($blockId));
        $this->sponsors->delete($blockId);
        $this->redirect('Summary:');
    }

    public function deleteMenu($entity) {
    	$this->myBlocks->deleteMenu($entity);
    }


}
