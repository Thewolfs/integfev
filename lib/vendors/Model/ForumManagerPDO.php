<?php
namespace Model;

use \Entity\Forum;
use \Entity\Categorie;

class ForumManagerPDO extends ForumManager
{
	public function getList()
	{
		$sql = "SELECT f.id f_id, f.nom as f_nom, f.description as f_desc, c.id c_id, c.nom as c_nom FROM forum f INNER JOIN categorie c ON id_categ = c.id";
		
		$requete = $this->dao->query($sql);
		
		$listeForum = array();
		
		while(($row = $requete->fetch(\PDO::FETCH_ASSOC)) !== false)
		{
			$forum = new Forum();
			$forum->setId($row['f_id']);
			$forum->setNom($row['f_nom']);
			$forum->setDescription($row['f_desc']);
			$categ = new Categorie();
			$categ->setId($row['c_id']);
			$categ->setNom($row['c_nom']);
			$forum->setCateg($categ);
			$listeForum[] = $forum;
		}
		
		$requete->closeCursor();
		
		return $listeForum;
	}
	
	public function getOne($idForum)
	{
		$sql = "SELECT * FROM Forum WHERE id = :id";
		
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
			'id' => $idForum
		));
		
		$row = $requete->fetch(\PDO::FETCH_ASSOC);
		
		$forum = new Forum();
		$forum->setId($row['id']);
		$forum->setNom($row['nom']);
		$forum->setDescription($row['description']);
		
		return $forum;
	}
}