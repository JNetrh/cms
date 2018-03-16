<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Member as Member;
use App\Model\Members as Members;

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

        $defaults = $this->members[$blockId]->getFormProperties();
        $this->id = $defaults['id'];
        $defaultColors = $this->members[$blockId]->getColorProperties();
        $this['membersForm']->setDefaults($defaults);
        $this->template->data = $defaults;
        $this->template->colors = $defaultColors;
        $this->template->members = $this->members[$blockId]->getMembers();
    }

    public function handleDeleteMember($memberId, $blockId){
        $this->members[$blockId]->getMemberById($memberId)->delete();
        $this->redirect('Members:edit', $blockId);
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

        $data = $form->getHttpData();
        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;
        $blockId = $this->id;
        $hardData = [];
        $metaData = [];
        $path = is_int($blockId) ? $this->members[$blockId]->getImage() : null;
        $file = $data['image'];
        $arrayKeys = [];



        $hardData['heading_1'] = $data['heading_1'];
        $hardData['active'] = $data['active'];
        $hardData['position'] = $data['position'];

        if($file != null){
            $hardData['bg_type'] = 'image';
            if(!$file->isImage() and !$file->isOk())
                $form['image']->addError('Image was not ok');
        }
        else{
            $hardData['bg_type'] = 'color';
        }

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

        $hardData['style'] = json_encode($metaData);

        if(isset($blockId)){
            $member = $this->members[$blockId];
        }
        else{
            $member = new Members($this->database);
        }

        if($file != null){
            $file_ext=strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
            $path = UPLOAD_DIR.'img/repo/' . uniqid(rand(0,20), TRUE).$file_ext;

            if($blockId){
                $oldImg = $member->getImage();
                if(file_exists($oldImg)){
                    unlink($oldImg);
                }
            }


            $file->move($path);
        }



        if(!$form->hasErrors()){
            $member->setData($hardData['style'], $hardData['bg_type'], $hardData['heading_1'], $hardData['active'], $hardData['position'], $path);
            $member->saveToDb();
            $id = $member->getId();
            $this->members[$id] = $member;
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