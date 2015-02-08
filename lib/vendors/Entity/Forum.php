<?php 
namespace Entity;

use OCFram\Entity;

class Forum extends Entity
{
	protected 	$nom,
				$description,
				$categ;
				
	const NOM_INVALIDE = 1;
	const DESCRIPTION_INVALIDE = 2;
				
	public function isValid()
	{
		return !(empty($this->nom) || empty($this->description));
	}
	
	// SETTERS //
	
	public function setNom($nom)
	{
		if(empty($nom) || !is_string($nom))
			$this->erreurs[] = self::NOM_INVALIDE;
		
		$this->nom = htmlspecialchars($nom);
	}
	
	public function setDescription($description)
	{
		if(empty($description) || !is_string($description))
			$this->erreurs[] = self::DESCRIPTION_INVALIDE;
		
		$this->description = htmlspecialchars($description);
	}
	
	public function setCateg(Categorie $categ)
	{		
		$this->categ = $categ;
	}
	
	// GETTERS //
	
	public function nom()
	{
		return $this->nom;
	}
	
	public function description()
	{
		return $this->description;
	}
	
	public function categ()
	{
		return $this->categ;
	}
}