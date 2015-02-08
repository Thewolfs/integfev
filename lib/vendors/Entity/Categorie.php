<?php
namespace Entity;

use OCFram\Entity;

class Categorie extends Entity
{
	protected $nom;
	
	const NOM_INVALIDE = 1;
	
	public function isValid()
	{
		return !(empty($this->nom) || !is_string($this->nom));
	}
	
	// SETTERS // 
	
	public function setNom($nom)
	{
		if(empty($nom) || !is_string($nom))
			$this->erreurs[] = self::NOM_INVALIDE;
		
		$this->nom = htmlspecialchars($nom);
	}
	
	// GETTERS //
	
	public function nom()
	{
		return $this->nom;
	}
}