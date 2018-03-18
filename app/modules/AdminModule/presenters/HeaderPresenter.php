<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Headers as Header;

class HeaderPresenter extends SecuredBasePresenter {

    private $database;
    public $headers;
    public $id;

    public function __construct(Nette\Database\Context $database, BF $blockFactory)
    {
        $this->database = $database;
        $this->headers = $blockFactory->getBlockHeader();
    }

    public function renderDefault(){

    }

    public function handleDeleteImg($id) {
        $this->headers[$id]->deleteImage();
        $this->redirect('Header:edit', $id);
    }


    public function actionEdit($blockId){

        $defaults = $this->headers[$blockId]->getFormProperties();
        bdump($defaults);
        $this->id = $defaults['id'];
        $defaultColors = $this->headers[$blockId]->getColorProperties();
        $this['headerForm']->setDefaults($defaults);
        $this->template->data = $defaults;
        $this->template->colors = $defaultColors;
    }

    public function createComponentHeaderForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

//        $form -> addTextArea('heading_1');
        $form -> addText('heading_1');
        $form -> addText('heading_1_color');
        $form -> addText('heading_2');
//        $form -> addTextArea('heading_2');
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
        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;
        $blockId = $this->id;
        $hardData = [];
        $metaData = [];
        $path = is_int($blockId) ? $this->headers[$blockId]->getImage() : null;
        $file = $data['image'];
        $arrayKeys = [];

        $hardData = [
            'heading_1' => $data['heading_1'],
            'heading_2' => $data['heading_2'],
            'button_1' => $data['button_1'],
            'button_2' => $data['button_2'],
            'button_1_link' => $data['button_1_link'],
            'button_2_link' => $data['button_2_link'],
            'active' => $data['active'],
            'position' => $data['position']
        ];


        if($file != null){
            $hardData['bg_type'] = 'image';
            if(!$file->isImage() and !$file->isOk())
                $form['image']->addError('Image was not ok');
        }
        else{
            $hardData['bg_type'] = 'color';
        }

        if(strlen($data['button_1_link']) < 2)
            $hardData['button_1_link'] = '#';
        if(strlen($data['button_2_link']) < 2)
            $hardData['button_2_link'] = '#';

        unset($data['heading_1'], $data['heading_2']);
        unset($data['button_1'], $data['button_2']);
        unset($data['button_1_link'], $data['button_2_link']);
        unset($data['active']);
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

        if(isset($blockId)){
            $header = $this->headers[$blockId];
        }
        else{
            $header = new Header($this->database);
        }

        if($file != null){
            $file_ext=strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
            $path = UPLOAD_DIR.'img/repo/' . uniqid(rand(0,20), TRUE).$file_ext;

            if($blockId){
                $oldImg = $this->database->table('block_header')->where('id', $blockId)->fetch()->image;
                if(file_exists($oldImg)){
                    unlink($oldImg);
                }
            }


            $file->move($path);
        }

        bdump($hardData);


        if(!$form->hasErrors()){
            $header->setData($hardData['style'], $hardData['bg_type'], $hardData['heading_1'], $hardData['heading_2'], $hardData['button_1'], $hardData['button_1_link'], $hardData['button_2'], $hardData['button_2_link'], $path, $hardData['active'], $hardData['position']);
            $header->saveToDb();
            $id = $header->getId();
            $this->headers[$id] = $header;
            $this->redirect('Summary:');
        }




        bdump($data); //ZDE













    }











}