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
	public function renderAkce2() {$this->terminate();}
	public function actionAkce2()
	{
		$httpRequest = $this->getHttpRequest();
		
	$firstname = $httpRequest->getPost('firstname');
	$lastname = $httpRequest->getPost('lastname');
	 $age = intval($httpRequest->getPost('age'));
	
	$this->database->table('student')->insert(array('firstname'=>$firstname,'lastname'=>$lastname,'age'=>$age));
	}

	public function actionWebView($facebookID)
	{
	$player = $this->database->table('player')->where('facebookID = ' . $facebookID);
	$arr = array();
	foreach ($player as $player)
	{
			$arr[] = array("facebookID"=>$player->facebookID,"score"=>$player->score,"level"=>$player->level);
	}
	$this->payload->data = $arr;
	$this->sendPayload($arr);
	}
	public function actionNewUser($facebookID)
	{
	$player = $this->database->table('player')->where('facebookID = ' . $facebookID);
	$arr = array();
	foreach ($player as $player)
	{
			$arr[] = array("facebookID"=>$player->facebookID,"score"=>$player->score,"level"=>$player->level);
	}
	$this->payload->data = $arr;
	$this->sendPayload($arr);
	}
	public function actionInsertFingerprint($fingerprint)
	{
	$player = $this->database->table('fingerprint')->where('facebookID = ' . $facebookID);
	$arr = array();
	foreach ($player as $player)
	{
			$arr[] = array("facebookID"=>$player->facebookID,"score"=>$player->score,"level"=>$player->level);
	}
	$this->payload->data = $arr;
	$this->sendPayload($arr);
	}


}
