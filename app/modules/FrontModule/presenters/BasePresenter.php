<?php

namespace App\FrontModule\Presenters;

use Nette;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    public function startup()
    {
        parent::startup();
    }

    protected function beforeRender()
    {
    }
}
