<?php

namespace App\Presenters;

use Nette;
use Gitkit_Client;
class AndroidPresenter extends BasePresenter
{
	/** @var Nette\Database\Context */
	private $database;

	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}
    // -------------------------------------------------------------------------------------------------
	/**
	 * Posle se token a vrati userId
	 */
    function validate($token)
	{
		$gitkitClient = Gitkit_Client::createFromFile(dirname(__FILE__) . './gitkit/gitkit-server-config.json');
		return $gitkitClient->validateToken($token)->getUserId();
	}

    // -------------------------------------------------------------------------------------------------
	
	public function actionLoginPlayer()
	{
		$httpRequest = $this->getHttpRequest();
        $userId = $this->validate($httpRequest->getPost('token'));


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
        $userId = $this->validate($httpRequest->getPost('token'));
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
        $userId = $this->validate($httpRequest->getPost('token'));
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
        $userId = $this->validate($httpRequest->getPost('token'));
        $ID_fraction = $httpRequest->getPost('ID_fraction');
        $this->database->table('player')->where('userId',$userId)->update(array('ID_fraction' => $ID_fraction));
    }
    public function actionGetPlayerFraction()
    {
        $httpRequest = $this->getHttpRequest();
        $userId = $this->validate($httpRequest->getPost('token'));
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
	public function actionSendScan()
	{
		$httpRequest = $this->getHttpRequest();
        $userId = $this->validate($httpRequest->getPost('token'));
		$qr = $httpRequest->getPost('qr');
		$fingerprint = $httpRequest->getPost('fingerprint');
		$scanWhen = $httpRequest->getPost('scanWhen');
        $player = $this->database->table('player')->where('userId = ' . $userId);
        foreach ($player as $player)
        {
            $ID_player = $player->ID_player;
        }
        // TODO poznani vlajky podle qr kodu
       // $ID_flag = $this->database->table('flag')->where('qr = ' . $qr);
        $ID_flag = $qr;

        $this->database->table('scan')->insert(array('ID_player' => $ID_player, 'ID_flag' => $ID_flag,
        'fingerprint' => $fingerprint, 'scanWhen' => $scanWhen));
        $scan = $this->database->table('scan')->where('scanWhen = ? AND ID_player = ?', $scanWhen, $ID_player);
		$arr = array();
		foreach ($scan as $scan) {
			$arr[] = array('scanWhen' => $scan->scanWhen);
		}
		$this->payload->scan = $arr;
		$this->sendPayload($arr);
	}
	public function actionChangePlayerName()
    {
        $httpRequest = $this->getHttpRequest();
        $userId = $this->validate($httpRequest->getPost('token'));
        $nickname = $httpRequest->getPost('nickname');
        $this->database->table('player')->where('userId',$userId)->update(array('nickname' => $nickname));
		
		$player = $this->database->table('player')->where('userId = ?', $userId);
		$arr = array();
		foreach ($player as $player) {
			$arr[] = array('nickname' => $player->nickname);
		}
		$this->payload->player = $arr;
		$this->sendPayload($arr);
    }
	public function actionChangePlayerScore()
    {
        $httpRequest = $this->getHttpRequest();
        $userId = $this->validate($httpRequest->getPost('token'));
        $player = $this->database->table('player')->where('userId = ' . $userId);
        foreach ($player as $player)
        {
            $score = $player->score;
        }	
		// +1 pricteni bodu za zabrani vlajky
        $this->database->table('player')->where('userId',$userId)->update(array('score' => $score + 1));
		
		$player = $this->database->table('player')->where('userId = ?', $userId);
		$arr = array();
		foreach ($player as $player) {
			$arr[] = array('score' => $player->score);
		}
		$this->payload->player = $arr;
		$this->sendPayload($arr);
    }
}
