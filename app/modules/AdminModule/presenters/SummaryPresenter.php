<?php

namespace App\AdminModule\Presenters;

use Nette;
use App\Model\BlockFactory as BF;

class SummaryPresenter extends SecuredBasePresenter {

    public $database;
    private $members;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
        $this->createMembers();
        $this->members = \App\Model\BlockFactory();
    }


    public function renderDefault(){
        $this->template->members = $this->members;

        bdump($this->members);
    }




}
