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

	
	public function actionNewPlayer()
	{
		$httpRequest = $this->getHttpRequest();	
		$facebookID = intval($httpRequest->getPost('facebookID'));
		$this->database->table('player')->insert(array('facebookID'=>$facebookID));
	}
	

	
	public function actionGetPlayerID()
	{
		$httpRequest = $this->getHttpRequest();	
		$facebookID = $httpRequest->getPost('facebookID');
	$player = $this->database->table('player')->where('facebookID = ' . $facebookID);
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
		$facebookID = $httpRequest->getPost('facebookID');
	$player = $this->database->table('player')->where('facebookID = ' . $facebookID);
	$arr = array();
	foreach ($player as $player)
	{
			$arr[] = array("score"=>$player->score,"level"=>$player->level);
	}
	$this->payload->data = $arr;
	$this->sendPayload($arr);
	}
	public function actionWebViewScoreFraction()
	{
		$httpRequest = $this->getHttpRequest();	
		$ID_fraction = intval($httpRequest->getPost('ID_fraction'));
	$flag = $this->database->table('flag')->where('ID_fraction = ' . $ID_fraction);
	$arr = count($flag);
	
	$this->payload->score = $arr;
	$this->sendPayload($arr);
	}
}
