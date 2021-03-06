<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Services\MemberService;

class MembersPresenter extends SecuredBasePresenter {

    public $members;
    public $id;
    public $sId;
    public $service;

    public $blockFactory;

    public function __construct(BF $blockFactory, MemberService $service)
    {
        $this->service = $service;
        $this->members = $blockFactory->getBlockMembers();
        $this->blockFactory = $blockFactory;
    }

    public function renderNewMember($blockId){
        $this->template->blockId = $blockId;
    }

    public function actionEdit($blockId){
        $entity = $this->members->findById($blockId);
        $defaults = $entity->getFormProperties();
        $this->id = $entity->getId();
        $defaultColors = $entity->getColorProperties();
        $this['membersForm']->setDefaults($defaults);
        $this->template->linkId = $this->id;
        $this->template->data = $entity;
        $this->template->colors = $defaultColors;
        $this->template->members = $entity->getMembers();
    }

    public function actionEditMember($memberId, $blockId){
        $entity = $this->members->findSubById($blockId, $memberId);
        $this->sId = $entity->getId();
        $this['oneMemberForm']->setDefaults($entity->getFormProperties());
        $this->template->linkSId = $this->sId;
        $this->template->blockId = $blockId;
        $this->template->data = $entity;
    }

    public function handleDelete($blockId){
        $this->members->delete($blockId);
	    $this->flashMessage('Members block successfully removed');
        $this->redirect('Summary:');
    }

    public function handleDeleteMember($memberId, $blockId){
    	$member = $this->members->findSubById($blockId, $memberId)->getName();
        $this->members->deleteMember($blockId, $memberId);
	    $this->flashMessage("$member successfully removed");
        $this->redirect('Members:edit', $blockId);
    }


    public function handleDeleteImg($id) {
        $entity = $this->members->findById($id);
        $entity->deleteImage();
        $this->service->saveEntity($entity);
	    $this->flashMessage('Background image successfully removed');
        $this->redirect('Members:edit', $id);
    }

    public function handleDeleteSImg($id, $blockId) {
        $entity = $this->members->findSubById($blockId, $id);
        $entity->deleteImage();
        $this->service->saveEntity($entity);
	    $this->flashMessage('Image successfully removed');
        $this->redirect('Members:editMember', $id, $blockId);
    }

    public function createComponentMembersForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading_1');
        $form -> addText('heading_1_color');
        $form -> addText('text_color');
        $form -> addText('name_color');
        $form -> addText('background_color');
        $form -> addText('position');
        $form -> addCheckbox('active');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create block');


        $form->onSuccess[] = [$this, 'membersFormSucceeded'];

        return $form;
    }

    public function membersFormSucceeded($form, $values){
        $data = $form->getHttpData();

        if(isset($this->id)){
            $entity = $this->members->findById($this->id);
        }
        else {
            $entity = $this->members->newEntity();
        }

        $file = $data['image'];
        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;

        $entity->setActive($data['active']);
        $entity->setHeading($data['heading_1']);
        $entity->setPosition($data['position']);

        $path = $entity->getImage();

        if($file != null){
            $entity->setBgType('image');
            if(!$file->isImage() and !$file->isOk())
                $form['image']->addError('Image was not ok');
        }
        else{
            $entity->setBgType('color');
        }

        unset($data['heading_1'], $data['active'], $data['position'], $data['image']);

        $arrayKeys = array_keys($data);
        forEach($arrayKeys as $value){
            if(substr($value, 0, 1) != "_"){
                if(!($data[$value] == 'transparent' || (strlen($data[$value]) == 7 and substr($data[$value], 0, 1) == "#"))){
                    $form[$value]->addError('Wrong color type');
                }
            }
        }

        $entity->setStyle(json_encode($data));

        if($file != null){
            $file_ext = strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
            $newPath = UPLOAD_DIR.'img/repo/' . uniqid(rand(0,20), TRUE).$file_ext;
            if(file_exists($path)){
                unlink($path);
            }
            $entity->setImage($newPath);
            $file->move($newPath);
        }

        if(!$form->hasErrors()){
            $this->service->saveEntity($entity);
	        $this->blockFactory->setMenu($entity);
	        $this->flashMessage('Block successfully saved');
            $this->redirect('Summary:');
        }

    }

    public function createComponentOneMemberForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('name');
        $form -> addTextArea('text');
        $form -> addCheckbox('active');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create member');


        $form->onSuccess[] = [$this, 'oneMemberFormSucceeded'];

        return $form;
    }

    public function oneMemberFormSucceeded($form, $values){

        $data = $form->getHttpData();

        if(isset($this->sId)){
            $entity = $this->members->findSubById($data['block_id'], $this->sId);
        }
        else {
            $entity = $this->members->newSubEntity($data['block_id']);
        }

        $file = $data['image'];

        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;

        $entity->setName($data['name']);
        $entity->setText($data['text']);
        $entity->setOwner($this->members->findById($data['block_id']));
        $entity->setActive($data['active']);

        $path = $entity->getImage();

        if($file != null){
            $file_ext = strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
            $newPath = UPLOAD_DIR.'img/repo/' . uniqid(rand(0,20), TRUE).$file_ext;
            if(file_exists($path)){
                unlink($path);
            }
            $entity->setImage($newPath);
            $file->move($newPath);
        }

        if(!$form->hasErrors()){

            $this->service->saveEntity($entity);
	        $this->flashMessage('Sub Block successfully saved');
            $this->redirect('Members:edit', $entity->getOwner());
        }


    }











}