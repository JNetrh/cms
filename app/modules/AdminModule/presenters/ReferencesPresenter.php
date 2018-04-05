<?php

namespace App\AdminModule\Presenters;


use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Services\ReferenceService;

class ReferencesPresenter extends SecuredBasePresenter {

    public $references;
    public $id;
    public $sId;
    public $service;

    public $blockFactory;

    public function __construct(BF $blockFactory, ReferenceService $service)
    {
        $this->service = $service;
        $this->references = $blockFactory->getBlockReferences();
        $this->blockFactory = $blockFactory;
    }

    public function renderNewReference($blockId){
        $this->template->blockId = $blockId;
    }

    public function actionEdit($blockId){
        $entity = $this->references->findById($blockId);
        $defaults = $entity->getFormProperties();
        $this->id = $entity->getId();
        $defaultColors = $entity->getColorProperties();
        $this['referencesForm']->setDefaults($defaults);
        $this->template->linkId = $this->id;
        $this->template->data = $entity;
        $this->template->colors = $defaultColors;
        $this->template->references = $entity->getReferences();
    }

    public function actionEditReference($referenceId, $blockId){
        $entity = $this->references->findSubById($blockId, $referenceId);
        $this->sId = $entity->getId();
        $this['oneReferenceForm']->setDefaults($entity->getFormProperties());
        $this->template->linkSId = $this->sId;
        $this->template->blockId = $blockId;
        $this->template->data = $entity;
    }

    public function handleDelete($blockId){
        $this->references->delete($blockId);
        $this->redirect('Summary:');
    }

    public function handleDeleteReference($referenceId, $blockId){
        $this->references->deleteReference($blockId, $referenceId);
        $this->redirect('References:edit', $blockId);
    }

    public function handleDeleteImg($id) {
        $entity = $this->references->findById($id);
        $entity->deleteImage();
        $this->service->saveEntity($entity);
        $this->redirect('References:edit', $id);
    }

    public function handleDeleteSImg($id, $blockId) {
        $entity = $this->references->findSubById($blockId, $id);
        $entity->deleteImage();
        $this->service->saveEntity($entity);
        $this->redirect('References:editReference', $id, $blockId);
    }

    public function createComponentReferencesForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading');
        $form -> addText('heading_color');
        $form -> addText('text_color');
        $form -> addText('name_color');
        $form -> addText('block_background_color');
        $form -> addText('background_color');
        $form -> addText('position');
        $form -> addCheckbox('active');
        $form ->addUpload('image');

        $form->addSubmit('submit', 'Create block');


        $form->onSuccess[] = [$this, 'referencesFormSucceeded'];

        return $form;
    }

    public function referencesFormSucceeded($form, $values){
        $data = $form->getHttpData();

        if(isset($this->id)){
            $entity = $this->references->findById($this->id);
        }
        else {
            $entity = $this->references->newEntity();
        }

        $file = $data['image'];
        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;

        $entity->setActive($data['active']);
        $entity->setHeading($data['heading']);
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

        unset($data['heading'], $data['active'], $data['position'], $data['image']);

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
            $this->redirect('Summary:');
        }

    }

    public function createComponentOneReferenceForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('name');
        $form -> addTextArea('text');
        $form -> addCheckbox('active');
        $form -> addText('content');
        $form ->addUpload('image');

        $form->addSubmit('submit', 'Create reference');


        $form->onSuccess[] = [$this, 'oneReferenceFormSucceeded'];

        return $form;
    }

    public function oneReferenceFormSucceeded($form, $values){

        $data = $form->getHttpData();

        if(isset($this->sId)){
            $entity = $this->references->findSubById($data['block_id'], $this->sId);
        }
        else {
            $entity = $this->references->newSubEntity($data['block_id']);
        }

        $file = $data['image'];

        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;

        $entity->setName($data['name']);
        $entity->setText($data['text']);
        $entity->setReference($data['content']);
        $entity->setOwner($this->references->findById($data['block_id']));
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
            $this->redirect('References:edit', $entity->getOwner());
        }

//        $this->redirect('References', $entity->getOwner());

    }











}