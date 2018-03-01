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


    public function createComponentHeaderForm(){
        $form = new Form;
        $form -> addTextArea('heading_1');
        $form -> addTextArea('heading_2');
        $form -> addText('button_1');
        $form -> addText('button_2');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Obrázek musí být JPEG, PNG nebo GIF.');
        $form->addSubmit('submit', 'Vytvořit aktualitu');


        $this->template->newsForm = $form;

        $form->onSuccess[] = [$this, 'newsFormSucceeded'];

        return $form;
    }

}
