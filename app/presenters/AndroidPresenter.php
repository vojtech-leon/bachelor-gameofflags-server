<?php

namespace App\Presenters;

use Nette;


class AndroidPresenter extends BasePresenter
{
	/** @var Nette\Database\Context */
	private $database;


	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}


	public function renderShow()
	{
	$player = $this->database->table('player');
		if (!$player) {
			$this->error('Post not found');
		}

		$this->template->player = $player;
	}
	public function actionAkce()
	{
	$students = $this->database->table('student');
	$arr = array();
	foreach ($students as $student)
	{
			$arr[] = array("id"=>$student->id,"firstname"=>$student->firstname,"lastname"=>$student->lastname,"age"=>$student->age);
	}
	$this->payload->students = $arr;
	$this->sendPayload($arr);
	}
	public function actionAkce2()
	{
		$httpRequest = $this->getHttpRequest();
		
	$firstname = $httpRequest->getPost('firstname');
	$lastname = $httpRequest->getPost('lastname');
	 $age = intval($httpRequest->getPost('age'));
	
	$this->database->table('student')->insert(array('firstname'=>$firstname,'lastname'=>$lastname,'age'=>$age));
	}

	// ---------------------------- to nad jsou jen pokusy -----------------------

	public function actionLoginPlayer()
	{
		$httpRequest = $this->getHttpRequest();	
		$userId = $httpRequest->getPost('userId');


		$player = $this->database->table('player')->where('userId = ' . $userId);
		if(count($player) == 0) {  // pokud zadny neni
			$this->database->table('player')->insert(array('userId' => $userId));
			$player = $this->database->table('player')->where('userId = ' . $userId);
		}
		$arr = array();
		foreach ($player as $player)
		{
			$arr[] = array("nickname"=>$player->nickname);
		}
		$this->payload->player = $arr;
		$this->sendPayload($arr);
	}
	

	
	public function actionGetPlayerID()
	{
		$httpRequest = $this->getHttpRequest();	
		$userId = $httpRequest->getPost('userId');
	$player = $this->database->table('player')->where('userId = ' . $userId);
	$arr = array();
	foreach ($player as $player)
	{
			$arr[] = array("ID_player"=>$player->ID_player);
	}
	$this->payload->id = $arr;
	$this->sendPayload($arr);
	}


	public function actionWebViewPlayer()
	{
		$httpRequest = $this->getHttpRequest();	
		$userId = $httpRequest->getPost('userId');
	$player = $this->database->table('player')->where('userId = ' . $userId);
	$arr = array();
	foreach ($player as $player)
	{
			$arr[] = array("score"=>$player->score,"level"=>$player->level);
	}
	$this->payload->player = $arr;
	$this->sendPayload($arr);
	}
	public function actionWebViewScoreFraction()
	{
		$httpRequest = $this->getHttpRequest();	
		$ID_fraction = intval($httpRequest->getPost('ID_fraction'));
	$flag = $this->database->table('flag')->where('ID_fraction = ' . $ID_fraction);
	$arr[] = array("score"=>count($flag));
	
	$this->payload->fraction = $arr;
	$this->sendPayload($arr);
	}
    public function actionChangeFraction()
    {
        $httpRequest = $this->getHttpRequest();
        $userId = $httpRequest->getPost('userId');
        $ID_fraction = intval($httpRequest->getPost('ID_fraction'));

        // tak nevim co je spatne
        $this->database->table('player')->where('userId = ' . $userId)->update(array('ID_fraction' => $ID_fraction));
    }
    public function actionGetPlayerFraction()
    {
        $httpRequest = $this->getHttpRequest();
        $userId = $httpRequest->getPost('userId');
        $player = $this->database->table('player')->where('userId = ' . $userId);
        $arr = array();
        foreach ($player as $player)
        {
            $arr[] = array("ID_fraction"=>$player->ID_fraction,"changeFractionWhen"=>$player->changeFractionWhen);
        }
        $this->payload->player = $arr;
        $this->sendPayload($arr);
    }
    public function actionGetFractionName()
    {
        $httpRequest = $this->getHttpRequest();
        $ID_fraction = $httpRequest->getPost('ID_fraction');
        $fraction = $this->database->table('fraction')->where('ID_fraction = ' . $ID_fraction);
        $arr = array();
        foreach ($fraction as $fraction) {
            $arr[] = array("name" => $fraction->name);
        }
        $this->payload->fraction = $arr;
        $this->sendPayload($arr);
    }
}
