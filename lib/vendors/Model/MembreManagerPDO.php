<?php
namespace Model;

use \Entity\Membre;

class MembreManagerPDO extends MembreManager
{
	public function getOneByPseudo($pseudo)
	{
		$sql = "SELECT * FROM Membre WHERE pseudo = :pseudo";
		
		$requete = $this->dao->prepare($sql);
		$requete->execute(array(
		'pseudo' => $pseudo
		));
		
		$row = $requete->fetch(\PDO::FETCH_ASSOC);
		
		$membre = new Membre();
		$membre->setId($row['id']);
		$membre->setPseudo($row['pseudo']);
		$membre->setPass($row['pass']);
		$membre->setDroit($row['droit']);
		$membre->setImg($row['img']);
		$membre->setSignature($row['signature']);
		
		return $membre;
	}
	
	public function add(Membre $membre)
	{
		$sql = "INSERT INTO membre(pseudo, pass, droit, img) VALUES(:pseudo, :pass, 1, 'default.jpg')";
		
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
		'pseudo' => $membre->pseudo(),
		'pass' => $membre->pass()
		));
	}
	
	public function modify(Membre $membre)
	{
		$sql = "UPDATE membre SET pseudo = :pseudo, pass = :pass, img = :img, signature = :sign WHERE id = :id";
		
		$requete = $this->dao->prepare($sql);
		$requete->execute(array(
		'pseudo' => $membre->pseudo(),
		'pass' => $membre->pass(),
		'img' => $membre->img(),
		'sign' => $membre->signature(),
		'id' => $membre->id()
		));
	}
}