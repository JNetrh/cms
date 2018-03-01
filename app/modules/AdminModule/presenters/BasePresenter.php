<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Utils\Strings;
use App\Model\Authenticator;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /** @var Authenticator @inject */
    public $authenticator;


    public function startup()
    {
        parent::startup();

        if($this->getUser()){
            if($this->getUser()->isLoggedIn()){
                $this->redirect('Main:');
            }
            if(!$this->getUser()->isLoggedIn()){
//                $this->redirect('Sign:in');
            }
            if ($this->name == 'Admin:presigned' and !$this->getUser()->isLoggedIn()) {
//                $this->redirect('Sign:in');
//                info o userovi zustane!!!!!
//                $this->flashMessage('Access denied');
//                $this->redirect('Uvod:');
            }
        }
        else{
//            $this->redirect('Sign:in');
        }


    }


    public function actionLogout()
    {
        $this->getUser()->logout();
        $this->flashMessage('Byl/a jste odhlášen.');
        $this->redirect(":Front:Homepage:");
    }




}
