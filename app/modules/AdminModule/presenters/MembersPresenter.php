<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;

class MembersPresenter extends SecuredBasePresenter {

    public function __construct()
    {

    }

    public function renderNewMember($blockId){
        $this->template->blockId = $blockId;
    }

    public function createComponentMembersForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading_1');
        $form -> addText('heading_1_color');
        $form -> addText('text_color');
        $form -> addText('name_color');
        $form -> addText('background_color');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create block');


        $form->onSuccess[] = [$this, 'membersFormSucceeded'];

        return $form;
    }

    public function membersFormSucceeded($form, $values){

        $data = $form->getHttpData();
        $hardData = [];

        $hardData = [
            'heading_1' => $data['heading_1'],
        ];

        bdump($data);

    }

    public function createComponentOneMemberForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading');
        $form -> addText('description');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create member');


        $form->onSuccess[] = [$this, 'oneMemberFormSucceeded'];

        return $form;
    }

    public function oneMemberFormSucceeded($form, $values){

        $data = $form->getHttpData();
        $hardData = [];

        $hardData = [
            'heading' => $data['heading'],
        ];

        bdump($data);

    }











}