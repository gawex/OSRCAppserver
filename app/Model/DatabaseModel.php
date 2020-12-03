<?php

namespace App\Model;

use Nette;

class DatabaseModel
{
	use Nette\SmartObject;

	/** @var Nette\Database\Context */
	private $database;

	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	public function getAllData()
	{
            $records = $this->database->fetchAll('SELECT * FROM data ORDER BY data.da_timestamp ASC');
            return $records;
            
        }
        
        public function getLastHourData()
	{
            $from = new Nette\Utils\DateTime;
            $to = new Nette\Utils\DateTime;
            $hour = $from->format('H');
            $from->setTime($hour, 0, 0);
            $to->setTime($hour, 59, 59);
            $records = $this->database->fetchAll('SELECT * FROM data WHERE data.da_timestamp BETWEEN ? AND ? ORDER BY data.da_timestamp ASC', $from, $to);
            return $records;
        }
        
        public function insertRandomTemperature(){
            $temp = rand(-10000, 10000);
            $temp /= 100;
            $this->database->table('data')->insert([
		'da_temperature' => $temp,
                ]);
            $row = $this->database->fetch('SELECT da_temperature, da_timestamp FROM data ORDER BY data.da_timestamp DESC LIMIT 1');
            return 'V ' . $row->da_timestamp->format('H:i:s d. m. Y') . ' byla do databáze vložena nová hodnota teploty: ' . $row->da_temperature . ' °C';
        }
        
}