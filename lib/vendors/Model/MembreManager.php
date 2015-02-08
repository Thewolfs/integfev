<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Membre;

abstract class MembreManager extends Manager
{
	abstract public function getOneByPseudo($pseudo);
	
	abstract public function add(Membre $membre);
	
	abstract public function modify(Membre $membre);
	
	public function save(Membre $membre)
	{
		if($membre->isNew())
			$this->add($membre);
		else 
			$this->modify($membre);
	}
}