<?php

namespace App\AdminModule\Presenters;

use App\Model\Members;
use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Reference as Reference;
use App\Model\References as References;

class ReferencesPresenter extends SecuredBasePresenter {

    private $database;
    public $references;
    public $id;
    public $rId;

    public function __construct(Nette\Database\Context $database, BF $blockFactory)
    {
        $this->database = $database;
        $this->references = $blockFactory->getBlockReferences();
    }

    public function renderNewReference($blockId){
        $this->template->blockId = $blockId;
    }

    public function actionEdit($blockId){
        $defaults = $this->references[$blockId]->getFormProperties();
        $this->id = $defaults['id'];
        $defaultColors = $this->references[$blockId]->getColorProperties();
        $this['referencesForm']->setDefaults($defaults);
        $this->template->data = $defaults;
        $this->template->colors = $defaultColors;
        $this->template->references = $this->references[$blockId]->getReferences();
    }

    public function handleDeleteReference($referenceId, $blockId){
        $this->references[$blockId]->getReferenceById($referenceId)->delete();
        $this->redirect('References:edit', $blockId);
    }


    public function handleDeleteImg($id) {
        $this->references[$id]->deleteImage();
        $this->redirect('References:edit', $id);
    }


    public function actionEditReference($referenceId, $blockId){

        $defaults = $this->references[$blockId]->getReferenceById($referenceId)->getFormProperties();
        $this->rId = $defaults['id'];
        $this['oneReferenceForm']->setDefaults($defaults);
        $this->template->blockId = $blockId;
        $this->template->data = $defaults;
    }

    public function createComponentReferencesForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading');
        $form -> addText('heading_color');
        $form -> addText('text_color');
        $form -> addText('name_color');
        $form -> addText('block_background_color');
        $form -> addText('background_color');
        $form -> addText('position');
        $form -> addCheckbox('active');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create block');


        $form->onSuccess[] = [$this, 'referencesFormSucceeded'];

        return $form;
    }

    public function referencesFormSucceeded($form, $values){

        $data = $form->getHttpData();
        bdump($data);
        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;
        $blockId = $this->id;
        $hardData = [];
        $metaData = [];
        $path = is_int($blockId) ? $this->references[$blockId]->getImage() : null;
        $file = $data['image'];
        $arrayKeys = [];

        $hardData['heading'] = $data['heading'];
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



        unset($data['heading'], $data['active'], $data['position'], $data['image']);

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
            $reference = $this->references[$blockId];
        }
        else{
            $reference = new References($this->database);
        }

        if($file != null){
            $file_ext=strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
            $path = UPLOAD_DIR.'img/repo/' . uniqid(rand(0,20), TRUE).$file_ext;

            if($blockId){
                $oldImg = $this->database->table('block_references')->where('id', $blockId)->fetch()->image;
                if(file_exists($oldImg)){
                    unlink($oldImg);
                }
            }

            $hardData['image'] = $path;

            $file->move($path);
        }


        if(!$form->hasErrors()){
            $reference->setData($hardData['style'], $hardData['bg_type'], $hardData['heading'], $hardData['active'], $hardData['position'], $path);
            $reference->saveToDb();
            $id = $reference->getId();
            $this->references[$id] = $reference;
            $this->redirect('Summary:');
        }


        bdump($data); //ZDE






    }

    public function createComponentOneReferenceForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('name');
        $form -> addTextArea('text');
        $form -> addText('content');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create reference');


        $form->onSuccess[] = [$this, 'oneReferenceFormSucceeded'];

        return $form;
    }

    public function oneReferenceFormSucceeded($form, $values){
        $data = $form->getHttpData();
        $referenceId = $this->rId;
        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;

        $path = is_int($referenceId) ? $this->references[$data['block_id']]->getReferenceById($referenceId)->getImage() : null;
        $file = $data['image'];


        if(isset($referenceId)){
            $reference = $this->references[$data['block_id']]->getReferenceById($referenceId);
        }
        else{
            $reference = new Reference($this->database);
        }


        if($file != null){
            if(!$file->isImage() and !$file->isOk())
                $form['image']->addError('Image was not ok');

            $file_ext=strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
            $path = UPLOAD_DIR.'img/repo/' . uniqid(rand(0,20), TRUE).$file_ext;

            if($referenceId){
                $oldImg = $this->database->table('referencese')->where('id', $referenceId)->fetch()->image;
                if(file_exists($oldImg)){
                    unlink($oldImg);
                }
            }

            $file->move($path);
        }

        if(!$form->hasErrors()){
            $reference->setData($data['name'], $data['text'], $path, $data['block_id'], $data['active'], $data['content']);
            $reference->saveToDb();
            $id = $reference->getId();
            $this->references[$id] = $reference;
        }

        $this->redirect('References:edit', $data['block_id']);

    }











}