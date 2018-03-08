<?php

namespace App\FrontModule\Presenters;

use Nette;
use Nette\Application\UI\Form;


class HomepagePresenter  extends BasePresenter
{
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function renderDefault(){

    }

}
