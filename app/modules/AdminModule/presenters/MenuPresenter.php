<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Services\MenuService;

class MenuPresenter extends SecuredBasePresenter {

    public $menus;
    public $entity;
    public $blocks;
    public $items;
    public $id;
    public $sId;
    public $service;

    public function __construct(BF $blockFactory, MenuService $service)
    {
        $this->service = $service;
        $this->menus = $blockFactory->getBlockMenus();
        $this->blocks = $blockFactory->getAllBlocks();
        $this->entity = $this->menus->getOne();
    }

    public function renderNewMenu($blockId){
        $this->template->blockId = $blockId;
    }

    public function actionEdit(){
        $entity = $this->entity;
        $defaults = $entity->getFormProperties();
        $this->id = $entity->getId();
        $this->items = $entity->getMenus();
        $defaultColors = $entity->getColorProperties();
        $this['menusForm']->setDefaults($defaults);
        $this->template->linkId = $this->id;
        $this->template->data = $entity;
        $this->template->colors = $defaultColors;
        $this->template->items = $entity->getMenus();
        $this->template->blocks = $this->blocks;
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
        $entity = $this->entity;
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
    	$data = $form->getHttpData();
	    $superArray = [];

    	bdump($form->getHttpData());

	    $entity = $this->menus->getOne();
//	    $menuItems = $entity->getMenus();

	    $entity->setFacebook($data['facebook']);
	    $entity->setLinkedin($data['linkedin']);
	    $entity->setTwitter($data['twitter']);
	    $entity->setInstagram($data['instagram']);
	    $entity->setHeading($data['heading']);


	    $file = $data['image'];
	    $path = $entity->getImage();

        if($file != null){
            $entity->setBgType('image');
            if(!$file->isImage() and !$file->isOk())
                $form['image']->addError('Image was not ok');
        }
        else{
            $entity->setBgType('color');
        }

    	unset($data['facebook'],$data['linkedin'],$data['twitter'],$data['instagram'],$data['heading'], $data['image']);

		foreach ($entity->getMenus() as $row){
			$row->setActive(0);
		}

        $arrayKeys = array_keys($data);
    	foreach ($arrayKeys as $input){
    		$superArray[] = explode('_', $input);
	    }

	    $style = [];
        forEach($superArray as $value){
        	$itemName = $value[0]."_".$value[1];
        	$item = null;
        	bdump($data);
        	if($value[0] == 'newext'){
        		if(isset($data['newext_text']) and $data['newext_text'] != ""){
			        $item = $this->menus->newSubEntity(1);
			        $item->setText($data['newext_text']);
			        $item->setLink($data['newext_link']);
			        $item->setPosition($data['newext_position']);
			        $item->setBlockOwner('ext');
			        $item->setOwner($this->entity);
			        if(isset($data['newext_checkbox'])){
				        $item->setActive(1);
				        unset($data['newext_checkbox']);
			        }
			        else {
				        $item->setActive(0);
			        }
			        unset($data['newext_link']);
			        unset($data['newext_position']);
			        unset($data['newext_text']);
		        }
        	}
            if(end($value) === 'color'){
            	$style[implode('_', $value)] = $data[implode('_', $value)];
            }
            elseif (end($value) === 'text'){
				if($value[0] == 'ext'){ #pak se může objevit i link a je to update
					$item = $entity->findById($value[1]);
					$item->setText($data[implode('_', $value)]);
				}
				elseif($value[0] != 'newext'){
					$item = $entity->findByBlock($itemName);
					$item->setText($data[implode("_",$value)]);
				}
            }
            elseif (end($value) === 'checkbox'){
	            if($value[0] == 'ext'){
		            $item = $entity->findById($value[1]);
		            $item->setActive(1);
	            }
	            elseif($value[0] != 'newext'){
		            $item = $entity->findByBlock($itemName);
		            $item->setActive(1);
	            }
            }
            elseif (end($value) === 'position'){
	            if($value[0] == 'ext'){
		            $item = $entity->findById($value[1]);
		            $item->setPosition($data[implode('_', $value)]);
	            }
	            elseif($value[0] != 'newext'){
		            $item = $entity->findByBlock($itemName);
		            $item->setPosition($data[implode('_', $value)]);
	            }
            }
            elseif (end($value) === 'link'){
	            if($value[0] == 'ext'){
		            $item = $entity->findById($value[1]);
		            $item->setLink($data[implode('_', $value)]);
	            }
            }

            if($item != null){
        		$this->service->updateEntity($item);
            }
        }

	    $this->service->saveChanges();

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
            $this->redirect('Menu:edit');
        }

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