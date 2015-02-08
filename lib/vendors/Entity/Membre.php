<?php
namespace Entity;

use OCFram\Entity;

class Membre extends Entity
{
	protected	$pseudo,
				$pass,
				$droit,
				$img,
				$signature;
				
	const PSEUDO_INVALIDE = 1;
	const PASS_INVALIDE = 2;
	const DROIT_INVALIDE = 3;
	const IMG_INVALIDE = 4;
	const SIGNATURE_INVALIDE = 5;
				
	public function isValid()
	{
		return !(empty($this->pseudo) || empty($this->pass) || empty($this->droit) || empty($this->img));
	}
	
	// SETTERS //
	
	public function setPseudo($pseudo)
	{
		if(empty($pseudo) || !is_string($pseudo))
			$this->erreurs[] = self::PSEUDO_INVALIDE;
		
		$this->pseudo = htmlspecialchars($pseudo);
	}
	
	public function setPass($pass)
	{
		if(empty($pass) || !is_string($pass))
			$this->erreurs[] = self::PASS_INVALIDE;
		
		$this->pass = htmlspecialchars($pass);
	}
	
	public function setDroit($droit)
	{
		if(empty($droit))
			$this->erreurs[] = self::DROIT_INVALIDE;
		
		$this->droit = htmlspecialchars($droit);
	}
	
	public function setImg($img)
	{
		if(empty($img) || !is_string($img))
			$this->erreurs[] = self::IMG_INVALIDE;
		
		$this->img = htmlspecialchars($img);
	}
	
	public function setSignature($signature)
	{
		if(!is_string($signature))
			$this->erreurs[] = self::SIGNATURE_INVALIDE;
		
		$this->signature = htmlspecialchars($signature);
	}
	
	// GETTERS //
	
	public function pseudo()
	{
		return $this->pseudo;
	}
	
	public function pass()
	{
		return $this->pass;
	}
	
	public function droit()
	{
		return $this->droit;
	}
	
	public function img()
	{
		return $this->img;
	}
	
	public function signature()
	{
		return $this->signature;
	}
}