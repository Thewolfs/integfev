<?php
namespace Model;

use \Entity\Topic;
use \Entity\Forum;

class TopicManagerPDO extends TopicManager
{
	public function getTopicCount($idForum)
	{
		$sql = "SELECT COUNT(*) FROM topic WHERE id_forum = :idForum";
		
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
		"idForum" => $idForum
		));
		
		return $requete->fetchColumn();
	}
	
	public function getList($idForum)
	{
		$sql = "SELECT t.id as t_id, t.nom as t_nom, f.id as f_id, f.nom as f_nom  FROM topic t INNER JOIN Forum f ON t.id_forum = f.id WHERE t.id_forum = :idForum";
		
		$requete = $this->dao->prepare($sql);
				
		$requete->execute(array(
		"idForum" => $idForum
		));
		
		$listeTopic = array();
		
		while(($row = $requete->fetch(\PDO::FETCH_ASSOC)) !== false)
		{
			$topic = new Topic();
			$topic->setId($row['t_id']);
			$topic->setNom($row['t_nom']);
			
			$forum = new Forum();
			$forum->setId($row['f_id']);
			$forum->setNom($row['f_nom']);
			
			$topic->setForum($forum);
			
			$listeTopic[] = $topic;
		}
		
		return $listeTopic;
	}
	
	public function getOne($idTopic)
	{
		$sql = "SELECT t.id as t_id, t.nom as t_nom, f.id as f_id, f.nom as f_nom  FROM topic t INNER JOIN Forum f ON t.id_forum = f.id WHERE t.id_topic = :idTopic";
		
		$requete = $this->dao->prepare($sql);
				
		$requete->execute(array(
			"idTopic" => $idTopic
		));
		
		$row = $requete->fetch(\PDO::FETCH_ASSOC);
		
		$topic = new Topic();
		$topic->setId($row['t_id']);
		$topic->setNom($row['t_nom']);
		
		$forum = new Forum();
		$forum->setId($row['f_id']);
		$forum->setNom($row['f_nom']);
		
		$topic->setForum($forum);
		
		return $topic;
	}
	
	public function getLastIdInsert()
	{
		$sql = "SELECT LAST_INSERT_ID() FROM topic";
		
		$requete = $this->dao->query($sql);
		
		return $requete->fetchColumn();
	}
	
	public function add(Topic $topic)
	{
		$sql = "INSERT INTO topic(nom, id_forum) VALUES(:nom, :id_forum)";
		
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
			'nom' => $topic->nom(),
			'id_forum' => $topic->forum()->id()
		));
	}
	
	public function delete(Topic $topic)
	{
		$sql = "DELETE FROM topic WHERE id = :id";
		
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
			'id' => $topic->id()
		));
	}
}