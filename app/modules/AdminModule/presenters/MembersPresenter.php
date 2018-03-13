<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;

class MembersPresenter extends SecuredBasePresenter {

    public $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function renderNewMember($blockId){
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
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create block');


        $form->onSuccess[] = [$this, 'membersFormSucceeded'];

        return $form;
    }

    public function membersFormSucceeded($form, $values){

        $data = $form->getHttpData();
        $headerId = $this->getParameter('id');
//        $isImage = $this->database->table('block_header')->where('active', 1); // možnost mít vícero hlaviček, co když dělám novou a takový záznam neexistuje, jak vybrat mezi existujícími tu správnou? - nějaké ID si předávat?
        $hardData = [];
        $metaData = [];
        $file = $data['image'];
        $arrayKeys = [];

        $hardData = [
            'heading_1' => $data['heading_1'],
            'active' => 1,
            'position' => $data['position']
        ];
        if($file != null){
            $hardData['bg_type'] = 'image';
            if(!$file->isImage() and !$file->isOk())
                $form['image']->addError('Image was not ok');
        }



        unset($data['heading_1']);
        unset($data['image']);
        unset($data['position']);

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

        if($file != null){
            $file_ext=strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
            $path = UPLOAD_DIR.'img/repo/' . uniqid(rand(0,20), TRUE).$file_ext;

            if($headerId){
                $oldImg = $this->database->table('block_members')->where('id', $headerId)->fetch()->image;
                if(file_exists($oldImg)){
                    unlink($oldImg);
                }
            }

            $hardData['image'] = $path;

            $file->move($path);
        }



        if(!$form->hasErrors()){
            $this->database->table('block_members')->update(['active' => 0]);
            if(!$headerId){
                $this->database->table('block_members')->insert($hardData);
            }
            else{
                $this->database->table('block_members')->where('id', $headerId)->update($hardData);
            }

            $this->redirect('Main:');

        }


        bdump($data); //ZDE






    }

    public function createComponentOneMemberForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading');
        $form -> addText('description');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create member');


        $form->onSuccess[] = [$this, 'oneMemberFormSucceeded'];

        return $form;
    }

    public function oneMemberFormSucceeded($form, $values){

        $data = $form->getHttpData();
        $hardData = [];

        $hardData = [
            'heading' => $data['heading'],
        ];

        bdump($data);

    }











}