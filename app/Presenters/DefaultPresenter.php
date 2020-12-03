<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;

class DefaultPresenter extends Nette\Application\UI\Presenter
{
	public function renderDefault(): void
	{
		$this->template->payload = 'DEFAULT';//$this->databaseModel->getPublicArticles();
	}
        
}
