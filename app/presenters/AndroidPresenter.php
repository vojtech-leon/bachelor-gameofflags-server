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


		$player = $this->database->table('player')->where('userId = ?', $userId);
		if(count($player) == 0) {  // pokud zadny neni
			$this->database->table('player')->insert(array('userId' => $userId));
			$player = $this->database->table('player')->where('userId = ?', $userId);
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
	$player = $this->database->table('player')->where('userId = ?', $userId);
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
	$player = $this->database->table('player')->where('userId = ?', $userId);
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
	$flag = $this->database->table('flag')->where('ID_fraction = ?', $ID_fraction);
	$arr[] = array("score"=>count($flag));

	$this->payload->fraction = $arr;
	$this->sendPayload($arr);
	}
    public function actionChangeFraction()
    {
        $httpRequest = $this->getHttpRequest();
        $userId = $this->validate($httpRequest->getPost('token'));
        $ID_fraction = $httpRequest->getPost('ID_fraction');
        $this->database->table('player')->where('userId',$userId)->update(array('ID_fraction' => $ID_fraction, 'changeFractionWhen' => new \DateTime()));
		
		$arr[] = array("zmeneno"=>"ano");
		$this->payload->fraction = $arr;
		$this->sendPayload($arr);
	}
    public function actionGetPlayerFraction()
    {
        $httpRequest = $this->getHttpRequest();
        $userId = $this->validate($httpRequest->getPost('token'));
        $player = $this->database->table('player')->where('userId = ?', $userId);
        $arr = array();
        foreach ($player as $player)
        {
			$ID_fraction = $player->ID_fraction;
            $changeFractionWhen = $player->changeFractionWhen;
        }
		$fraction = $this->database->table('fraction')->where('ID_fraction = ?', $ID_fraction);
        foreach ($fraction as $fraction) {
            $arr[] = array("ID_fraction"=> $ID_fraction,"changeFractionWhen"=> $changeFractionWhen, "fractionName" => $fraction->name);
        }
		
        $this->payload->player = $arr;
        $this->sendPayload($arr);
    }
	public function actionSendScan()
	{
		$httpRequest = $this->getHttpRequest();
        $userId = $this->validate($httpRequest->getPost('token'));
		$flag = $httpRequest->getPost('flag');
		$fingerprint = $httpRequest->getPost('fingerprint');
		$scanWhen = $httpRequest->getPost('scanWhen');
        $player = $this->database->table('player')->where('userId = ?', $userId);
        foreach ($player as $player)
        {
            $ID_player = $player->ID_player;
        }
        $ID_flag = $flag;

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
		// +1 pricteni bodu za zabrani vlajky
        $this->database->table('player')->where('userId',$userId)->update(array('score' => new \Nette\Database\SqlLiteral('score + 1')));
		$player = $this->database->table('player')->where('userId = ?', $userId);
		$arr = array();
		foreach ($player as $player) {
			$arr[] = array('score' => $player->score);
		}
		$this->payload->player = $arr;
		$this->sendPayload($arr);
    }
	public function actionChangeFlagOwner()
    {
        $httpRequest = $this->getHttpRequest();
        $userId = $this->validate($httpRequest->getPost('token'));
        $ID_flag = $httpRequest->getPost('ID_flag');
        $player = $this->database->table('player')->where('userId = ?', $userId);
        foreach ($player as $player)
        {
            $ID_fraction = $player->ID_fraction;
			$ID_player = $player->ID_player;
        }
		// +1 pricteni k poctu zabrani (pro statisticke ucely)
        $this->database->table('flag')->where('ID_flag',$ID_flag)->update(array('ID_fraction' => $ID_fraction, 'ID_player' => $ID_player, 'flagWhen' => new \DateTime(), 'taken' => new \Nette\Database\SqlLiteral('taken + 1')));
		$flag = $this->database->table('flag')->where('ID_flag = ?', $ID_flag);
		$arr = array();
		foreach ($flag as $flag) {
			$arr[] = array('ID_flag' => $flag->ID_flag);
		}
		$this->payload->flag = $arr;
		$this->sendPayload($arr);
    }

	// stejny hrac, i kdyz zmeni frakci, nemuze zabrat znovu stejnou vlajku
	public function actionGetFlagInfoUser()
    {
        $httpRequest = $this->getHttpRequest();
        $userId = $this->validate($httpRequest->getPost('token'));
        $ID_flag = $httpRequest->getPost('ID_flag');
        $player = $this->database->table('player')->where('userId = ?', $userId);
        foreach ($player as $player)
        {
			$ID_player = $player->ID_player;
			$ID_fraction = $player->ID_fraction;
        }	
		$flag = $this->database->table('flag')->where('ID_flag = ?', $ID_flag);
		$arr = array();
		foreach ($flag as $flag) {
			if ($flag->ID_player == $ID_player) {
				$flagMe = true;
			} else {
				$flagMe = false;
			}
			if ($flag->ID_fraction == $ID_fraction) {
				$fractionMe = true;
			} else {
				$fractionMe = false;
			}
			$arr[] = array('flagWhen' => $flag->flagWhen, 'flagMe' => $flagMe, 'fractionMe' => $fractionMe,
			'ID_fraction' => $ID_fraction, 'floor' => $flag->floor, 'x' => $flag->x, 'y' => $flag->y);
		}
		$this->payload->flag = $arr;
		$this->sendPayload($arr);
    }
	public function actionGetFlagInfo()
    {
        $httpRequest = $this->getHttpRequest();
        $floor = $httpRequest->getPost('floor');
		$flag = $this->database->table('flag')->where('floor = ?', $floor);
		$arr = array();
		foreach ($flag as $flag) {
			$arr[] = array('ID_flag' => $flag->ID_flag, 'flagWhen' => $flag->flagWhen, 'ID_fraction' => $flag->ID_fraction, 'x' => $flag->x, 'y' => $flag->y);
		}
		$this->payload->flag = $arr;
		$this->sendPayload($arr);
    }
	public function actionGetFlagInfoFull()
    {
        $httpRequest = $this->getHttpRequest();
        $ID_flag = $httpRequest->getPost('ID_flag');
		$flag = $this->database->table('flag')->where('ID_flag = ?', $ID_flag);
		$arr = array();
		foreach ($flag as $flag) {
			$flagWhen = $flag->flagWhen;
			$ID_fraction = $flag->ID_fraction;
			$flagName = $flag->name;
			$ID_player = $flag->ID_player;
		}
		$playerNameDB = $this->database->table('player')->select('nickname')->where('ID_player = ?', $ID_player);
		foreach ($playerNameDB as $playerNameDB) {
			$playerName = $playerNameDB->nickname;
		}
		$fractionNameDB = $this->database->table('fraction')->select('name')->where('ID_fraction = ?', $ID_fraction);
		foreach ($fractionNameDB as $fractionNameDB) {
			$fractionName = $fractionNameDB->name;
		}
		$arr[] = array('flagWhen' => $flagWhen, 'flagName' => $flagName, 'playerName' => $playerName, 'fractionName' => $fractionName);
		$this->payload->flag = $arr;
		$this->sendPayload($arr);
    }
	public function actionGetQrCodes()
    {
		$flag = $this->database->table('flag');
		$arr = array();
		foreach ($flag as $flag) {
			$arr[] = array('qrCode' => $flag->qrCode);	
		}
		$this->payload->flag = $arr;
		$this->sendPayload($arr);
    }
}
