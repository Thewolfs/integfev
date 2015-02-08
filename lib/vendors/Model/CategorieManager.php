<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Topic;

abstract class CategorieManager extends Manager
{	
	abstract public function getList();
	
	abstract public function getOne($idCateg);
	
	abstract public function getLastIdInsert();
	
	abstract public function add(Categorie $categ);
	
	public function save(Categorie $categ)
	{
		if($topic->isNew())
			$this->add($topic);
		else 
			$this->modify($topic);
	}
	
	abstract public function delete(Topic $topic);
}