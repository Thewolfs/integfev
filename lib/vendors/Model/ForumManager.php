<?php
namespace Model;

use \OCFram\Manager;

abstract class ForumManager extends Manager
{
	abstract public function getList();
	
	abstract public function getOne($idForum);
}