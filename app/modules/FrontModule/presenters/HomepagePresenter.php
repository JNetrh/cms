<?php

namespace App\FrontModule\Presenters;

use Nette;
use App\Model\BlockFactory as BF;


class HomepagePresenter  extends BasePresenter
{

	private $visibleBlocks;

	public function __construct(BF $blockFactory)
	{
		$this->visibleBlocks = $blockFactory->getAllBlocks();
	}

    public function renderDefault(){
		$this->template->visibleBlocks = $this->visibleBlocks;
    }

}
