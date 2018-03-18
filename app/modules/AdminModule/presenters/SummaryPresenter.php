<?php

namespace App\AdminModule\Presenters;

use Nette;
use App\Model\BlockFactory as BF;

class SummaryPresenter extends SecuredBasePresenter {

    public $database;
    private $members;
    private $headers;
    private $references;
    private $myBlocks;

    public function __construct(Nette\Database\Context $database, BF $blockFactory)
    {
        $this->database = $database;

        $this->members = $blockFactory->getBlockMembers();
        $this->headers = $blockFactory->getBlockHeader();
        $this->references = $blockFactory->getBlockReferences();
        $this->myBlocks = $blockFactory->getAllBlocks();
    }


    public function renderDefault(){
        $this->template->members = $this->members;
        $this->template->headers = $this->headers;
        $this->template->references = $this->references;
        $this->template->myBlocks = $this->myBlocks;

    }


    public function handleDeleteMember($blockId){
       $this->members[$blockId]->delete();
        $this->redirect('Summary:');
    }

    public function handleDeleteHeader($blockId){
       $this->headers[$blockId]->delete();
        $this->redirect('Summary:');
    }

    public function handleDeleteReference($blockId){
       $this->references[$blockId]->delete();
        $this->redirect('Summary:');
    }


}
