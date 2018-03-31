<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Services\SponsorService;

class SponsorsPresenter extends SecuredBasePresenter {

    public $sponsors;
    public $id;
    public $sId;
    public $service;

    public function __construct(BF $blockFactory, SponsorService $service)
    {
        $this->service = $service;
        $this->sponsors = $blockFactory->getBlockSponsors();
    }

    public function renderNewSponsor($blockId){
        $this->template->blockId = $blockId;
    }

    public function actionEdit($blockId){
        $entity = $this->sponsors->findById($blockId);
        $defaults = $entity->getFormProperties();
        $this->id = $entity->getId();
        $defaultColors = $entity->getColorProperties();
        $this['sponsorsForm']->setDefaults($defaults);
        $this->template->linkId = $this->id;
        $this->template->data = $entity;
        $this->template->colors = $defaultColors;
        $this->template->sponsors = $entity->getSponsors();
    }

    public function actionEditSponsor($sponsorId, $blockId){
        $entity = $this->sponsors->findSubById($blockId, $sponsorId);
        $this->sId = $entity->getId();
        $this['oneSponsorForm']->setDefaults($entity->getFormProperties());
        $this->template->linkSId = $this->sId;
        $this->template->blockId = $blockId;
        $this->template->data = $entity;
    }

    public function handleDelete($blockId){
        $this->sponsors->delete($blockId);
        $this->redirect('Summary:');
    }

    public function handleDeleteSponsor($sponsorId, $blockId){
        $this->sponsors->deleteSponsor($blockId, $sponsorId);
        $this->redirect('Sponsors:edit', $blockId);
    }

    public function handleDeleteImg($id) {
        $entity = $this->sponsors->findById($id);
        $entity->deleteImage();
        $this->service->saveEntity($entity);
        $this->redirect('Sponsors:edit', $id);
    }

    public function handleDeleteSImg($id, $blockId) {
        $entity = $this->sponsors->findSubById($blockId, $id);
        $entity->deleteImage();
        $this->service->saveEntity($entity);
        $this->redirect('Sponsors:edit', $blockId);
    }

    public function createComponentSponsorsForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading');
        $form -> addText('heading_color');
        $form -> addText('background_color');
        $form -> addText('block_background_color');
        $form -> addText('position');
        $form -> addCheckbox('active');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create block');


        $form->onSuccess[] = [$this, 'sponsorsFormSucceeded'];

        return $form;
    }

    public function sponsorsFormSucceeded($form, $values){
        $data = $form->getHttpData();

        if(isset($this->id)){
            $entity = $this->sponsors->findById($this->id);
        }
        else {
            $entity = $this->sponsors->newEntity();
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
            $this->redirect('Summary:');
        }

    }

    public function createComponentOneSponsorForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('link');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create sponsor');


        $form->onSuccess[] = [$this, 'oneSponsorFormSucceeded'];

        return $form;
    }

    public function oneSponsorFormSucceeded($form, $values){

        $data = $form->getHttpData();

        if(isset($this->sId)){
            $entity = $this->sponsors->findSubById($data['block_id'], $this->sId);
        }
        else {
            $entity = $this->sponsors->newSubEntity($data['block_id']);
        }

        $file = $data['image'];

        $entity->setLink($data['link']);
        $entity->setOwner($this->sponsors->findById($data['block_id']));

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
            $this->redirect('Sponsors:edit', $entity->getOwner());
        }

//        $this->redirect('Sponsors:edit', $entity->getOwner());

    }


}