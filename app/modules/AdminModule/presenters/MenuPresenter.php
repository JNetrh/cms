<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Services\MenuService;

class MenuPresenter extends SecuredBasePresenter {

    public $menus;
    public $items;
    public $id;
    public $sId;
    public $service;

    public function __construct(BF $blockFactory, MenuService $service)
    {
        $this->service = $service;
        $this->menus = $blockFactory->getBlockMenus();
    }

    public function renderNewMenu($blockId){
        $this->template->blockId = $blockId;
    }

    public function actionEdit(){
        $entity = $this->menus->getOne();
        $defaults = $entity->getFormProperties();
        $this->id = $entity->getId();
        $this->items = $entity->getMenus();
        $defaultColors = $entity->getColorProperties();
        $this['menusForm']->setDefaults($defaults);
        $this->template->linkId = $this->id;
        $this->template->data = $entity;
        $this->template->colors = $defaultColors;
        $this->template->items = $entity->getMenus();
    }

//    public function actionEditMember($memberId, $blockId){
//        $entity = $this->members->findSubById($blockId, $memberId);
//        $this->sId = $entity->getId();
//        $this['oneMemberForm']->setDefaults($entity->getFormProperties());
//        $this->template->linkSId = $this->sId;
//        $this->template->blockId = $blockId;
//        $this->template->data = $entity;
//    }

//    public function handleDelete($blockId){
//        $this->menus->delete($blockId);
//        $this->redirect('Summary:');
//    }

    public function handleDeleteMenu($menuId, $blockId){
        $this->menus->deleteMenu($blockId, $menuId);
        $this->redirect('Menu:edit');
    }


    public function handleDeleteImg($blockMenu) {
        $entity = $this->menus->getOne();
        $entity->deleteImage();
        $this->service->saveEntity($entity);
	    $this->redirect('Menu:edit');
    }

//    public function handleDeleteSImg($id, $blockId) {
//        $entity = $this->members->findSubById($blockId, $id);
//        $entity->deleteImage();
//        $this->service->saveEntity($entity);
//        $this->redirect('Members:editMember', $id, $blockId);
//    }

    public function createComponentMenusForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading');
        $form -> addText('heading_color');
        $form -> addText('text_color');
        $form -> addText('inverted_text_color');
        $form -> addText('background_color');
        $form -> addText('inverted_background_color');
        $form -> addText('link');
        $form -> addText('text');
        $form -> addText('position');
        $form -> addText('facebook');
        $form -> addText('instagram');
        $form -> addText('linkedin');
        $form -> addText('twitter');
        $form -> addCheckbox('active');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create block');


        $form->onSuccess[] = [$this, 'menusFormSucceeded'];

        return $form;
    }

    public function menusFormSucceeded($form, $values){
    	bdump($form->getHttpData());


//        $data = $form->getHttpData();
//
//        if(isset($this->id)){
//            $entity = $this->members->findById($this->id);
//        }
//        else {
//            $entity = $this->members->newEntity();
//        }
//
//        $file = $data['image'];
//        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;
//
//        $entity->setActive($data['active']);
//        $entity->setHeading($data['heading_1']);
//        $entity->setPosition($data['position']);
//
//        $path = $entity->getImage();
//
//        if($file != null){
//            $entity->setBgType('image');
//            if(!$file->isImage() and !$file->isOk())
//                $form['image']->addError('Image was not ok');
//        }
//        else{
//            $entity->setBgType('color');
//        }
//
//        unset($data['heading_1'], $data['active'], $data['position'], $data['image']);
//
//        $arrayKeys = array_keys($data);
//        forEach($arrayKeys as $value){
//            if(substr($value, 0, 1) != "_"){
//                if(!($data[$value] == 'transparent' || (strlen($data[$value]) == 7 and substr($data[$value], 0, 1) == "#"))){
//                    $form[$value]->addError('Wrong color type');
//                }
//            }
//        }
//
//        $entity->setStyle(json_encode($data));
//
//        if($file != null){
//            $file_ext = strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
//            $newPath = UPLOAD_DIR.'img/repo/' . uniqid(rand(0,20), TRUE).$file_ext;
//            if(file_exists($path)){
//                unlink($path);
//            }
//            $entity->setImage($newPath);
//            $file->move($newPath);
//        }
//
//        if(!$form->hasErrors()){
//            $this->service->saveEntity($entity);
//            $this->redirect('Summary:');
//        }

    }

//    public function createComponentOneMemberForm(){
//        $form = new Form();
//        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');
//
//        $form -> addText('name');
//        $form -> addTextArea('text');
//        $form -> addCheckbox('active');
//        $form ->addUpload('image')
//            ->addCondition(Form::FILLED)
//            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');
//
//        $form->addSubmit('submit', 'Create member');
//
//
//        $form->onSuccess[] = [$this, 'oneMemberFormSucceeded'];
//
//        return $form;
//    }

//    public function oneMemberFormSucceeded($form, $values){
//
//        $data = $form->getHttpData();
//
//        if(isset($this->sId)){
//            $entity = $this->members->findSubById($data['block_id'], $this->sId);
//        }
//        else {
//            $entity = $this->members->newSubEntity($data['block_id']);
//        }
//
//        $file = $data['image'];
//
//        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;
//
//        $entity->setName($data['name']);
//        $entity->setText($data['text']);
//        $entity->setOwner($this->members->findById($data['block_id']));
//        $entity->setActive($data['active']);
//
//        $path = $entity->getImage();
//
//        if($file != null){
//            $file_ext = strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
//            $newPath = UPLOAD_DIR.'img/repo/' . uniqid(rand(0,20), TRUE).$file_ext;
//            if(file_exists($path)){
//                unlink($path);
//            }
//            $entity->setImage($newPath);
//            $file->move($newPath);
//        }
//
//        if(!$form->hasErrors()){
//
//            $this->service->saveEntity($entity);
//            $this->redirect('Members:edit', $entity->getOwner());
//        }
//
////        $this->redirect('Members:edit', $entity->getOwner());
//
//    }











}