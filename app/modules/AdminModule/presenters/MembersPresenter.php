<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
//use App\Model\Member as Member;
//use App\Model\Members as Members;
use App\Model\Entities\BlockMembers as Members;
use App\Model\Entities\Member as Member;

class MembersPresenter extends SecuredBasePresenter {

    public $database;
    public $members;
    public $id;
    public $mId;

    public function __construct(Nette\Database\Context $database, BF $blockFactory)
    {
        $this->database = $database;
        $this->members = $blockFactory->getBlockMembers();
    }

    public function renderNewMember($blockId){
        $this->template->blockId = $blockId;
    }

    public function actionEdit($blockId){

        bdump($this->members);
        $defaults = $this->members->findById($blockId)->getFormProperties();
        $this->id = $defaults['id'];
        $defaultColors = $this->members->findById($blockId)->getColorProperties();
        $this['membersForm']->setDefaults($defaults);
        $this->template->data = $defaults;
        $this->template->colors = $defaultColors;
        $this->template->members = $this->members->findById($blockId);
    }

    public function handleDeleteMember($memberId, $blockId){
        $this->members[$blockId]->getMemberById($memberId)->delete();
        $this->redirect('Members:edit', $blockId);
    }


    public function handleDeleteImg($id) {
        $this->members[$id]->deleteImage();
        $this->redirect('Members:edit', $id);
    }


    public function actionEditMember($memberId, $blockId){

        $defaults = $this->members[$blockId]->getMemberById($memberId)->getFormProperties();
        $this->mId = $defaults['id'];
        $this['oneMemberForm']->setDefaults($defaults);
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

        $blockId = $this->id;
        if(isset($blockId)){
            $entity = $this->members->findById($blockId);
        }
        else {
            $entity = $this->members->newEntity();
        }



        $data = $form->getHttpData();
        $file = $data['image'];
        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;

        $entity->setActive($data['active']);

        $hardData = [];
        $metaData = [];
        $path = $this->members->findById($blockId)->getImage();

        $arrayKeys = [];



        $hardData['heading_1'] = $data['heading_1'];
        $hardData['active'] = $data['active'];
        $hardData['position'] = $data['position'];

        if($file != null){
            $entity->setBgType('image');
            if(!$file->isImage() and !$file->isOk())
                $form['image']->addError('Image was not ok');
        }
        else{
            $entity->setBgType('color');
        }

        $entity->setHeading($data['heading_1']);
        $entity->setActive($data['active']);
        $entity->setPosition($data['position']);

        unset($data['heading_1'], $data['active'], $data['position'], $data['image']);


        $metaData = $data;
        $arrayKeys = array_keys($data);
        forEach($arrayKeys as $value){
            if(substr($value, 0, 1) != "_"){
                if(!($metaData[$value] == 'transparent' || (strlen($metaData[$value]) == 7 and substr($metaData[$value], 0, 1) == "#"))){
                    $form[$value]->addError('Wrong color type');
                }

            }

        }

        $entity->setStyle(json_encode($metaData));



        if($file != null){
            $file_ext=strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
            $newPath = UPLOAD_DIR.'img/repo/' . uniqid(rand(0,20), TRUE).$file_ext;
            if(file_exists($path)){
                unlink($path);
            }

            $entity->setImage($newPath);

            $file->move($newPath);
        }



        if(!$form->hasErrors()){
//            $member->setData($hardData['style'], $hardData['bg_type'], $hardData['heading_1'], $hardData['active'], $hardData['position'], $path);
//            $member->saveToDb();
            $entity->saveEntity();
//            $id = $member->getId();
//            $this->members[$id] = $member;
            $this->redirect('Summary:');
        }



        bdump($data); //ZDE






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
        $memberId = $this->mId;
        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;


        $path = is_int($memberId) ? $this->members[$data['block_id']]->getMemberById($memberId)->getImage() : null;
        $file = $data['image'];


        if(isset($memberId)){
            $member = $this->members[$data['block_id']]->getMemberById($memberId);
        }
        else{
            $member = new Member($this->database);
        }


        if($file != null){
            if(!$file->isImage() and !$file->isOk())
                $form['image']->addError('Image was not ok');

            $file_ext=strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
            $path = UPLOAD_DIR.'img/repo/' . uniqid(rand(0,20), TRUE).$file_ext;

            if($memberId){
                $oldImg = $this->database->table('members')->where('id', $memberId)->fetch()->image;
                if(file_exists($oldImg)){
                    unlink($oldImg);
                }
            }

            $file->move($path);
        }

        if(!$form->hasErrors()){
            $member->setData($data['name'], $data['text'], $path, $data['block_id'], $data['active']);
            $member->saveToDb();
            $id = $member->getId();
            $this->members[$id] = $member;
        }

        $this->redirect('Members:edit', $data['block_id']);

    }











}