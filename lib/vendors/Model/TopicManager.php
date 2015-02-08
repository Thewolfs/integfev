<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Topic;

abstract class TopicManager extends Manager
{
	abstract public function getTopicCount($idForum);
	
	abstract public function getList($idForum);
	
	abstract public function getOne($idTopic);
	
	abstract public function getLastIdInsert();
	
	abstract public function add(Topic $topic);
	
	public function save(Topic $topic)
	{
		if($topic->isNew())
			$this->add($topic);
		else 
			$this->modify($topic);
	}
	
	abstract public function delete(Topic $topic);
}