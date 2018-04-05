<?php

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\BlockFactory as BF;
use App\Model\Services\ArticleService;

class ArticlesPresenter extends SecuredBasePresenter {

    public $articles;
    public $id;
    public $service;

    public $blockFactory;

    public function __construct(BF $blockFactory, ArticleService $service)
    {
        $this->service = $service;
        $this->articles = $blockFactory->getBlockArticles();
        $this->blockFactory = $blockFactory;
    }

    public function actionEdit($blockId){
        $entity = $this->articles->findById($blockId);
        $defaults = $entity->getFormProperties();
        $this->id = $entity->getId();
        $defaultColors = $entity->getColorProperties();
        $this['articlesForm']->setDefaults($defaults);
        $this->template->linkId = $this->id;
        $this->template->data = $entity;
        $this->template->colors = $defaultColors;
    }

    public function handleDelete($blockId){
        $this->articles->delete($blockId);
        $this->redirect('Summary:');
    }

    public function handleDeleteImg($id) {
        $entity = $this->articles->findById($id);
        $entity->deleteImage();
        $this->service->saveEntity($entity);
        $this->redirect('Articles:edit', $id);
    }

    public function handleDeleteImgArticle($id) {
        $entity = $this->articles->findById($id);
        $entity->deleteImageArticle();
        $this->service->saveEntity($entity);
        $this->redirect('Articles:edit', $id);
    }

    public function createComponentArticlesForm(){
        $form = new Form();
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form -> addText('heading_1');
        $form -> addText('heading_1_color');
        $form -> addText('heading_2');
        $form -> addText('heading_2_color');
        $form -> addTextArea('text');
        $form -> addText('text_color');
        $form -> addText('background_color');
        $form -> addText('position');
        $form -> addCheckbox('active');
        $form ->addUpload('image')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');
        $form ->addUpload('image_article')
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, 'Image has to be in format JPEG, PNG or GIF.');

        $form->addSubmit('submit', 'Create block');


        $form->onSuccess[] = [$this, 'articlesFormSucceeded'];

        return $form;
    }

    public function articlesFormSucceeded($form, $values){
        $data = $form->getHttpData();

        if(isset($this->id)){
            $entity = $this->articles->findById($this->id);
        }
        else {
            $entity = $this->articles->newEntity();
        }

        $file = $data['image'];
        $fileArticle = $data['image_article'];

        isset($data['active']) ? $data['active'] = 1 : $data['active'] = 0;

        $entity->setActive($data['active']);
        $entity->setHeading1($data['heading_1']);
        $entity->setHeading2($data['heading_2']);
        $entity->setPosition($data['position']);
        $entity->setText($data['text']);

        $path = $entity->getImage();
        $pathArticle = $entity->getImageArticle();

        if($file != null){
            $entity->setBgType('image');
            if(!$file->isImage() and !$file->isOk())
                $form['image']->addError('Image was not ok');
        }
        else{
            $entity->setBgType('color');
        }

        if($fileArticle != null){
            if(!$fileArticle->isImage() and !$fileArticle->isOk())
                $form['image_article']->addError('Image for article was not ok');
        }

        unset($data['heading_1'], $data['active'], $data['position'], $data['image'], $data['image_article']);
        unset($data['heading_2'], $data['text']);

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
        if($fileArticle != null){
            $file_ext_art = strtolower(mb_substr($fileArticle->getSanitizedName(), strrpos($fileArticle->getSanitizedName(), ".")));
            $newPathArticle = UPLOAD_DIR.'img/repo/' . uniqid(rand(0,20), TRUE).$file_ext_art;
            if(file_exists($pathArticle)){
                unlink($pathArticle);
            }
            $entity->setImageArticle($newPathArticle);
            $fileArticle->move($newPathArticle);
        }

        if(!$form->hasErrors()){
            $this->service->saveEntity($entity);
	        $this->blockFactory->setMenu($entity);
            $this->redirect('Summary:');
        }

    }


}