<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Services\ContactService;

class ContactsPresenter extends SecuredBasePresenter {

    public $contacts;
    public $id;
    public $service;

    public $blockFactory;

    public function __construct(BF $blockFactory, ContactService $service)
    {
        $this->service = $service;
        $this->contacts = $blockFactory->getBlockContacts();
        $this->blockFactory = $blockFactory;
    }

    public function actionEdit($blockId){
        $entity = $this->contacts->findById($blockId);
        $defaults = $entity->getFormProperties();
        $this->id = $entity->getId();
        $defaultColors = $entity->getColorProperties();
        $this['contactsForm']->setDefaults($defaults);
        $this->template->linkId = $this->id;
        $this->template->data = $entity;
        $this->template->colors = $defaultColors;
    }

    public function handleDelete($blockId){
        $this->contacts->delete($blockId);
	    $this->flashMessage('Block has been removed');
        $this->redirect('Summary:');
    }


    public function handleDeleteImg($id) {
        $entity = $this->contacts->findById($id);
        $entity->deleteImage();
        $this->service->saveEntity($entity);
	    $this->flashMessage('Image successfully removed');
        $this->redirect('Contacts:edit', $id);
    }

    public function createComponentContactsForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading_1');
        $form -> addText('heading_2');
        $form -> addText('heading_1_color');
        $form -> addText('heading_2_color');
        $form -> addText('text_color');
        $form -> addText('subHeading_color');
        $form -> addText('background_color');
        $form -> addText('block_background_color');
        $form -> addText('email');
        $form -> addText('phone');
        $form -> addText('adress');
        $form -> addText('gpsx');
        $form -> addText('gpsy');
        $form -> addText('instagram');
        $form -> addText('facebook');
        $form -> addText('twitter');
        $form -> addText('linkedin');
        $form -> addText('position');
        $form -> addCheckbox('active');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create block');


        $form->onSuccess[] = [$this, 'contactsFormSucceeded'];

        return $form;
    }

    public function contactsFormSucceeded($form, $values){
        $data = $form->getHttpData();

        if(isset($this->id)){
            $entity = $this->contacts->findById($this->id);
        }
        else {
            $entity = $this->contacts->newEntity();
        }

        $file = $data['image'];
        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;

        $entity->setActive($data['active']);
        $entity->setHeading1($data['heading_1']);
        $entity->setHeading2($data['heading_2']);
        $entity->setPosition($data['position']);
        $entity->setEmail($data['email']);
        $entity->setPhone($data['phone']);
        $entity->setAdress($data['adress']);
        $entity->setGpsx($data['gpsx']);
        $entity->setGpsy($data['gpsy']);
        $entity->setInstagram($data['instagram']);
        $entity->setFacebook($data['facebook']);
        $entity->setTwitter($data['twitter']);
        $entity->setLinkedin($data['linkedin']);

        $path = $entity->getImage();

        if($file != null){
            $entity->setBgType('image');
            if(!$file->isImage() and !$file->isOk())
                $form['image']->addError('Image was not ok');
        }
        else{
            $entity->setBgType('color');
        }

//        TODO: validace pro GPS
        unset($data['heading_1'], $data['active'], $data['position'], $data['image']);
        unset($data['heading_2'], $data['email'], $data['phone'], $data['adress']);
        unset($data['instagram'], $data['facebook'], $data['twitter'], $data['linkedin']);
        unset($data['gpsx'], $data['gpsy']);

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
	        $this->flashMessage('Block contacts successfully saved');
            $this->redirect('Summary:');
        }

    }



}