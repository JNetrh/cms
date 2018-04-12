<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Services\HeaderService;

class HeaderPresenter extends SecuredBasePresenter {

    public $headers;
    public $id;
    public $service;


    public function __construct(BF $blockFactory, HeaderService $service)
    {
        $this->service = $service;
        $this->headers = $blockFactory->getBlockHeader();
    }


    public function actionEdit($blockId){
        $entity = $this->headers->findById($blockId);
        $defaults = $entity->getFormProperties();
        $this->id = $entity->getId();
        $defaultColors = $entity->getColorProperties();
        $this['headerForm']->setDefaults($defaults);
        $this->template->linkId = $this->id;
        $this->template->data = $entity;
        $this->template->colors = $defaultColors;
    }

    public function handleDelete($blockId){
        $this->headers->delete($blockId);
	    $this->flashMessage('Header block successfully removed');
        $this->redirect('Summary:');
    }

    public function handleDeleteImg($id) {
        $entity = $this->headers->findById($id);
        $entity->deleteImage();
        $this->service->saveEntity($entity);
	    $this->flashMessage('Logo image successfully removed');
        $this->redirect('Header:edit', $id);
    }

    public function createComponentHeaderForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading_1');
        $form -> addText('heading_1_color');
        $form -> addText('heading_2');
        $form -> addText('heading_2_color');
        $form -> addText('button_1');
        $form -> addText('button_1_link');
        $form -> addText('button_1_color');
        $form -> addText('inverted_button_1_color');
        $form -> addText('inverted_button_1_background_color');
        $form -> addText('button_1_background_color');
        $form -> addText('button_1_border_color');
        $form -> addText('button_2');
        $form -> addText('button_2_link');
        $form -> addText('button_2_color');
        $form -> addText('inverted_button_2_color');
        $form -> addText('button_2_background_color');
        $form -> addText('inverted_button_2_background_color');
        $form -> addText('button_2_border_color');
        $form -> addText('background_color');
        $form -> addText('position');
        $form -> addCheckbox('active');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');
        $form->addSubmit('submit', 'Create block');


        $this->template->newsForm = $form;

        $form->onSuccess[] = [$this, 'headerFormSucceeded'];

        return $form;
    }

    public function headerFormSucceeded($form, $values){
        $data = $form->getHttpData();

        if(isset($this->id)){
            $entity = $this->headers->findById($this->id);
        }
        else {
            $entity = $this->headers->newEntity();
        }

        $file = $data['image'];
        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;

        $entity->setActive($data['active']);
        $entity->setHeading1($data['heading_1']);
        $entity->setHeading2($data['heading_2']);
        $entity->setButton1($data['button_1']);
        $entity->setButton1Link($data['button_1_link']);
        $entity->setButton2($data['button_2']);
        $entity->setButton2Link($data['button_2_link']);
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

        unset($data['active'], $data['position'], $data['image']);
        unset($data['heading_1'], $data['button_1'], $data['button_1_link']);
        unset($data['heading_2'], $data['button_2'], $data['button_2_link']);

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
	        $this->flashMessage('Header successfully saved');
            $this->redirect('Summary:');
        }
    }











}