<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Services\EventService;

class EventsPresenter extends SecuredBasePresenter {

    public $events;
    public $id;
    public $sId;
    public $service;

    public $blockFactory;

    public function __construct(BF $blockFactory, EventService $service)
    {
        $this->service = $service;
        $this->events = $blockFactory->getBlockEvents();
        $this->blockFactory = $blockFactory;
    }

    public function renderNewEvent($blockId){
        $this->template->blockId = $blockId;
    }

    public function actionEdit($blockId){
        $entity = $this->events->findById($blockId);
        $defaults = $entity->getFormProperties();
        $this->id = $entity->getId();
        $defaultColors = $entity->getColorProperties();
        $this['eventsForm']->setDefaults($defaults);
        $this->template->linkId = $this->id;
        $this->template->data = $entity;
        $this->template->colors = $defaultColors;
        $this->template->events = $entity->getEvents();
    }

    public function actionEditEvent($eventId, $blockId){
        $entity = $this->events->findSubById($blockId, $eventId);
        $this->sId = $entity->getId();
        $this['oneEventForm']->setDefaults($entity->getFormProperties());
        $this->template->linkSId = $this->sId;
        $this->template->blockId = $blockId;
        $this->template->data = $entity;
    }

    public function handleDelete($blockId){
        $this->events->delete($blockId);
        $this->redirect('Summary:');
    }

    public function handleDeleteEvent($eventId, $blockId){
        $this->events->deleteEvent($blockId, $eventId);
        $this->redirect('Events:edit', $blockId);
    }


    public function handleDeleteImg($id) {
        $entity = $this->events->findById($id);
        $entity->deleteImage();
        $this->service->saveEntity($entity);
        $this->redirect('Events:edit', $id);
    }

    public function handleDeleteSImg($blockId, $id) {
        $entity = $this->events->findSubById($blockId, $id);
        $entity->deleteImage();
        $this->service->saveEntity($entity);
        $this->redirect('Events:editEvent', $id, $blockId);
    }

    public function createComponentEventsForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading');
        $form -> addText('heading_color');
        $form -> addText('text_color');
        $form -> addText('time_color');
        $form -> addText('background_color');
        $form -> addText('block_background_color');
        $form -> addText('position');
        $form -> addCheckbox('active');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create block');


        $form->onSuccess[] = [$this, 'eventsFormSucceeded'];

        return $form;
    }

    public function eventsFormSucceeded($form, $values){
        $data = $form->getHttpData();

        if(isset($this->id)){
            $entity = $this->events->findById($this->id);
        }
        else {
            $entity = $this->events->newEntity();
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

    public function createComponentOneEventForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading');
        $form -> addText('event_time');
        $form -> addText('link');
        $form -> addTextArea('text');
        $form -> addCheckbox('active');
        $form -> addText('position');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create event');


        $form->onSuccess[] = [$this, 'oneEventFormSucceeded'];

        return $form;
    }

    public function oneEventFormSucceeded($form, $values){

        $data = $form->getHttpData();

        if(isset($this->sId)){
            $entity = $this->events->findSubById($data['block_id'], $this->sId);
        }
        else {
            $entity = $this->events->newSubEntity($data['block_id']);
        }

        $file = $data['image'];

        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;

        $entity->setHeading($data['heading']);
//        $entity->setEventTime($data['event_time']);
//        TODO: implement date
        $entity->setEventTime(new Nette\Utils\DateTime('22-03-2018 13:13:13'));
        $entity->setText($data['text']);
        $entity->setLink($data['link']);
        $entity->setOwner($this->events->findById($data['block_id']));
        $entity->setActive($data['active']);
        $entity->setPosition($data['position']);

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
            $this->redirect('Events:edit', $entity->getOwner());
        }

//        $this->redirect('Events:edit', $entity->getOwner());

    }











}