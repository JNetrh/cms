<?php

namespace App\FrontModule\Presenters;

use Nette;
use App\Model\BlockFactory as BF;


class HomepagePresenter  extends BasePresenter
{

	private $blocks;
	private $menu;
	private $seo;

	public function __construct(BF $blockFactory)
	{
		$this->blocks = $blockFactory->getAllBlocks();
		$this->menu = $blockFactory->getBlockMenus()->getOne();
		$this->seo = $blockFactory->getBlockSeo()->getOne();
	}

    public function renderDefault(){
		$this->template->blocks = $this->blocks;
		$this->template->menu = $this->menu;

		$this->template->keywords = $this->seo->getKeywords();
		$this->template->description = $this->seo->getDescription();
		$this->template->favicon = $this->seo->getFavicon();
    }

}
