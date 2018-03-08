<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;

class ReferencesPresenter extends SecuredBasePresenter {

    public function __construct()
    {

    }

    public function renderNewReference($blockId){
        $this->template->blockId = $blockId;
    }

    public function createComponentReferencesForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading_1');
        $form -> addText('heading_1_color');
        $form -> addText('text_color');
        $form -> addText('name_color');
        $form -> addText('block_background_color');
        $form -> addText('background_color');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create block');


        $form->onSuccess[] = [$this, 'referencesFormSucceeded'];

        return $form;
    }

    public function referencesFormSucceeded($form, $values){

        $data = $form->getHttpData();
        $hardData = [];

        $hardData = [
            'heading_1' => $data['heading_1'],
        ];

        bdump($data);

    }

    public function createComponentOneReferenceForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading');
        $form -> addText('description');
        $form -> addText('content');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create member');


        $form->onSuccess[] = [$this, 'oneReferenceFormSucceeded'];

        return $form;
    }

    public function oneReferenceFormSucceeded($form, $values){

        $data = $form->getHttpData();
        $hardData = [];

        $hardData = [
            'heading' => $data['heading'],
        ];

        bdump($data);

    }











}