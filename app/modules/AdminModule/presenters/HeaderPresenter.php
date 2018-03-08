<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;

class HeaderPresenter extends SecuredBasePresenter {

    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function renderDefault(){

    }

    public function createComponentHeaderForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addTextArea('heading_1');
        $form -> addText('heading_1_color');
        $form -> addTextArea('heading_2');
        $form -> addText('heading_2_color');
        $form -> addText('button_1');
        $form -> addText('button_1_link');
        $form -> addText('button_1_color');
        $form -> addText('button_1_background');
        $form -> addText('button_1_border');
        $form -> addText('button_2');
        $form -> addText('button_2_link');
        $form -> addText('button_2_color');
        $form -> addText('button_2_background');
        $form -> addText('button_2_border');
        $form -> addText('background_color');
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
        $headerId = $this->getParameter('id');
//        $isImage = $this->database->table('block_header')->where('active', 1); // možnost mít vícero hlaviček, co když dělám novou a takový záznam neexistuje, jak vybrat mezi existujícími tu správnou? - nějaké ID si předávat?
        $hardData = [];
        $metaData = [];
        $file = $data['image'];
        $arrayKeys = [];

        $hardData = [
            'heading_1' => $data['heading_1'],
            'heading_2' => $data['heading_2'],
            'button_1' => $data['button_1'],
            'button_2' => $data['button_2'],
            'button_1_link' => $data['button_1_link'],
            'button_2_link' => $data['button_2_link'],
            'active' => 1
        ];
        if($file != null){
            $hardData['bg_type'] = 'image';
            if(!$file->isImage() and !$file->isOk())
                $form['image']->addError('Image was not ok');
        }

        if(strlen($data['button_1_link']) < 2)
            $hardData['button_1_link'] = '#';
        if(strlen($data['button_2_link']) < 2)
            $hardData['button_2_link'] = '#';

        unset($data['heading_1'], $data['heading_2']);
        unset($data['button_1'], $data['button_2']);
        unset($data['button_1_link'], $data['button_2_link']);
        unset($data['image']);

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
                $oldImg = $this->database->table('block_header')->where('id', $headerId)->fetch()->image;
                if(file_exists($oldImg)){
                    unlink($oldImg);
                }
            }

            $hardData['image'] = $path;

            $file->move($path);
        }



        if(!$form->hasErrors()){
            $this->database->table('block_header')->update(['active' => 0]);
            if(!$headerId){
                $this->database->table('block_header')->insert($hardData);
            }
            else{
                $this->database->table('block_header')->where('id', $headerId)->update($hardData);
            }

            $this->redirect('Main:');

        }


        bdump($data); //ZDE













    }











}