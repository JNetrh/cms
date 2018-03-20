<?php

namespace App\AdminModule\Presenters;

use Nette;
use App\Model\BlockFactory as BF;
use App\Model\Services\ReferenceService;

class SummaryPresenter extends SecuredBasePresenter {

    public $database;

    private $members;
    private $headers;
    private $references;
    private $myBlocks;



    public function __construct(Nette\Database\Context $database, BF $blockFactory, ReferenceService $references)
    {
        $this->database = $database;
//        $this->references = $references->getEntities();
        $this->members = $blockFactory->getBlockMembers();
        $this->headers = $blockFactory->getBlockHeader();
        $this->references = $blockFactory->getBlockReferences();
        $this->myBlocks = $blockFactory;


//        $this->referenceService = $referenceService;
//
//        bdump($this->referenceService->getEntities()[0]);
//
//        foreach ($this->referenceService->getEntities()[0]->getReferences() as $row) {
//            bdump($row);
//        }

    }


    public function renderDefault(){
        $this->template->members = $this->members->getEntities();
        $this->template->headers = $this->headers->getEntities();
        $this->template->references = $this->references->getEntities();
        $this->template->myBlocks = $this->myBlocks->getAllBlocks();


    }


    public function handleDeleteMember($blockId){
       $this->members->delete($blockId);
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
