<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Services\SeoService;

class SeoPresenter extends SecuredBasePresenter {

    public $entity;
    public $id;
    public $service;
    public $seo;

    public function __construct(BF $blockFactory, SeoService $service)
    {
        $this->service = $service;
	    $this->seo = $blockFactory->getBlockSeo();
        $this->entity = $this->seo->getOne();
    }

    public function renderSeo($blockId){
        $this->template->blockId = $blockId;
    }

    public function actionEdit(){
        $entity = $this->entity;
        $defaults = $entity->getFormProperties();
        $this->id = $entity->getId();
        $this['seoForm']->setDefaults($defaults);
        $this->template->linkId = $this->id;
        $this->template->data = $entity;
    }


    public function handleDeleteImg($blockMenu) {
        $entity = $this->entity;
        $entity->deleteFavicon();
        $this->service->saveEntity($entity);
	    $this->redirect('Seo:edit');
    }

    public function createComponentSeoForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('keywords');
        $form -> addText('description');
        $form ->addUpload('favicon')
            ->addCondition(Form::FILLED);

        $form->addSubmit('submit', 'submit');


        $form->onSuccess[] = [$this, 'seoFormSucceeded'];

        return $form;
    }

    public function seoFormSucceeded($form, $values){
    	$data = $form->getHttpData();

	    $entity = $this->seo->getOne();

	    $entity->setKeywords($data['keywords']);
	    $entity->setDescription($data['description']);


	    $file = $data['favicon'];
	    $path = $entity->getFavicon();

        if($file != null){
            if(!$file->isOk()) {
	            $form['favicon']->addError('Image was not ok');
            }
        }

    	unset($data['keywords'],$data['description'],$data['favicon']);



	    $this->service->saveChanges();


        if($file != null){
            $file_ext = strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
            if($file_ext != '.ico'){
            	bdump($file_ext);
            	$form['favicon']->addError('image has to have .ico extension');
            	$form->addError('image problem');
            }
            $newPath = UPLOAD_DIR . uniqid(rand(0,20), TRUE).$file_ext;
            if(file_exists($path)){
                unlink($path);
            }
            $entity->setFavicon($newPath);
            $file->move($newPath);
        }

        if(!$form->hasErrors()){
            $this->service->saveEntity($entity);
            $this->redirect('Seo:edit');
        }



    }







}