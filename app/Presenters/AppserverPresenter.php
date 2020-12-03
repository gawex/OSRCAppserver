<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Utils\DateTime;
use Nette\Utils\Json;
use App\Model\DatabaseModel;

class AppserverPresenter extends Nette\Application\UI\Presenter
{
	/** @var ArticleManager */
	private $databaseModel;

	public function __construct(DatabaseModel $databaseModel)
	{
		$this->databaseModel = $databaseModel;
	}

	public function renderDefault(): void
	{
		$this->template->payload = 'DEFAULT APP SERVER';//$this->databaseModel->getPublicArticles();
	}
        
        public function actionTestconnection($command, $value): void
        {
            if($command === 'tryToConnect'){
                $this->template->payload = $value;
            } else {
               $this->error(); 
            }
        }
        
        public function actionHandledatabase($command, $value): void
        {
            
            switch ($command) {
                case 'getAllData':
                    $records = $this->databaseModel->getAllData();
                    foreach ($records as $record){
                       $record->da_timestamp = $record->da_timestamp->getTimeStamp();
                    }
                    $payload = Json::encode($records, Json::PRETTY);
                    break;
                case 'getLastHourData':
                    $records = $this->databaseModel->getLastHourData();
                    foreach ($records as $record){
                       $record->da_timestamp = $record->da_timestamp->getTimeStamp();
                    }
                    $payload = Json::encode($records, Json::PRETTY);
                    break;    
                case 'insertRandomTemperature':
                    $payload = $this->databaseModel->insertRandomTemperature();
                    break;
                default:
                    $payload = 'DEFAULT APP SERVER HANDLE DATABASE: COMMAND IS NULL!!!';
                    break;
            }
            $this->template->payload = $payload ;
        }
        
}