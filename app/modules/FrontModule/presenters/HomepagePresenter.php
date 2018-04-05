<?php

namespace App\FrontModule\Presenters;

use Nette;
use App\Model\BlockFactory as BF;


class HomepagePresenter  extends BasePresenter
{

	private $blocks;
	private $menu;

	public function __construct(BF $blockFactory)
	{
		$this->blocks = $blockFactory->getAllBlocks();
		$this->menu = $blockFactory->getBlockMenus()->getOne();
	}

    public function renderDefault(){
		$this->template->blocks = $this->blocks;
		$this->template->menu = $this->menu;
    }

}
