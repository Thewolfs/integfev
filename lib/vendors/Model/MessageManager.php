<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Message;

abstract class MessageManager extends Manager
{
	abstract public function getMessageCountForum($idForum);
	
	abstract public function getMessageCountTopic($idTopic);
	
	abstract public function getList($idTopic);
	
	abstract public function getOne($idMsg);
	
	abstract public function add(Message $message);
	
	abstract public function modify(Message $message);
	
	public function save(Message $message)
	{
		if($message->isNew())
			$this->add($message);
		else 
			$this->modify($message);
	}
}