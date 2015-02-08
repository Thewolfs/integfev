<?php
namespace Model;

use \Entity\Topic;
use \Entity\Forum;

class CategorieManagerPDO extends TopicManager
{	
	public function getList()
	{
		$sql = "SELECT * FORM categorie ORDER BY id";
		
		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Categorie');
		
		$liste = $requete->fetchAll();
		
		$requete->closeCursor();
		
		return $liste;
	}
	
	public function getOne($idCateg)
	{
		$sql = "SELECT * FROM categorie WHERE id = :idCateg";
		
		$requete = $this->dao->prepare($sql);
				
		$requete->execute(array(
			"idCateg" => $idCateg
		));
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Categorie');
		
		$topic = $requete->fetchAll();
		
		return $topic;
	}
	
	public function getLastIdInsert()
	{
		$sql = "SELECT LAST_INSERT_ID() FROM categorie";
		
		$requete = $this->dao->query($sql);
		
		return $requete->fetchColumn();
	}
	
	public function add(Categorie $categ)
	{
		$sql = "INSERT INTO topic(nom) VALUES(:nom)";
		
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
			'nom' => $categ->nom()
		));
	}
	
	public function delete(Categorie $categ)
	{
		$sql = "DELETE FROM Categorie WHERE id = :id";
		
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
			'id' => $categ->id()
		));
	}
}