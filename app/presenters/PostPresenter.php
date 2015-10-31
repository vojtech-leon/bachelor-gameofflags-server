<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;


class PostPresenter extends BasePresenter
{
	/** @var Nette\Database\Context */
	private $database;


	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}


	public function renderShow($studentId)
	{
		$student = $this->database->table('student')->get($studentId);
		if (!$student) {
			$this->error('Post not found');
		}

		$this->template->student = $student;
	}




}
