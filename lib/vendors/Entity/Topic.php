<?php
namespace Entity;

use OCFram\Entity;

class Topic extends Entity
{
	protected 	$nom,
				$forum;
				
	const NOM_INVALIDE = 1;
	
	public function isValid()
	{
		return !(empty($this->nom) || empty($this->forum));
	}
	
	// SETTERS //
	
	public function setNom($nom)
	{
		if(empty($nom) || !is_string($nom))
			$this->erreurs[] = self::NOM_INVALIDE;
		
		$this->nom = htmlspecialchars($nom);
	}
	
	public function setForum(Forum $forum)
	{
		$this->forum = $forum;
	}
	
	// GETTERS //
	
	public function nom()
	{
		return $this->nom;
	}
	
	public function forum()
	{
		return $this->forum;
	}
}