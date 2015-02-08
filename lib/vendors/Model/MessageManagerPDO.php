<?php
namespace Model;

use \Entity\Message;
use \Entity\Topic;
use \Entity\Membre;
use \Entity\Forum;

class MessageManagerPDO extends MessageManager
{
	public function getMessageCountForum($idForum)
	{
		$sql = "SELECT COUNT(*) FROM message WHERE id_forum = :idForum";
		
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
		"idForum" => $idForum
		));
		
		return $requete->fetchColumn();
	}
	
	public function getMessageCountTopic($idTopic)
	{
		$sql = "SELECT COUNT(*) FROM message WHERE id_topic = :idTopic";
		
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
		"idTopic" => $idTopic
		));
		
		return $requete->fetchColumn();
	}
	
	public function getList($idTopic)
	{
		$sql="	SELECT m.id as m_id, m.text as m_text, m.date as m_date, 
				mem1.id as mem1_id, mem1.pseudo as mem1_pseudo, mem1.pass as mem1_pass, mem1.img as mem1_img, mem1.signature as mem1_signature,  
				mem2.id as mem2_id, mem2.pseudo as mem2_pseudo, 
				t.id as t_id, t.nom as t_nom,
				f.id as f_id, f.nom as f_nom
				FROM message m 
				LEFT JOIN membre mem2 ON (m.id_membreedit = mem2.id) 
				INNER JOIN membre mem1 ON (m.id_membre = mem1.id) 
				INNER JOIN (topic t INNER JOIN forum f ON t.id_forum = f.id) ON (m.id_topic = t.id) 
				WHERE id_topic = :idTopic
				ORDER BY m.id";
		
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
		"idTopic" => $idTopic
		));
		
		$listeMsg = array();
		
		while(($row = $requete->fetch(\PDO::FETCH_ASSOC)) !== false)
		{
			$msg = new Message();
			$msg->setId($row['m_id']);
			$msg->setText($row['m_text']);
			$msg->setDate(new \DateTime($row['m_date']));
			
			$auteur = new Membre();
			$auteur->setId($row['mem1_id']);
			$auteur->setPseudo($row['mem1_pseudo']);
			$auteur->setPass($row['mem1_pass']);
			$auteur->setImg($row['mem1_img']);
			$auteur->setSignature($row['mem1_signature']);
			
			$msg->setMembre($auteur);
			
			$topic = new Topic();
			$topic->setId($row['t_id']);
			$topic->setNom($row['t_nom']);
			
			$forum = new Forum();
			$forum->setId($row['f_id']);
			$forum->setNom($row['f_nom']);
			
			$topic->setForum($forum);
			$msg->setForum($forum);
			
			$msg->setTopic($topic);
			
			if($row['mem2_id'])
			{
				$edit = new Membre();
				$edit->setId($row['mem2_id']);
				$edit->setPseudo($row['mem2_pseudo']);
				
				$msg->setMembreEdit($edit);
			}
			
			$listeMsg[] = $msg;
		}
		
		return $listeMsg;
	}
	
	public function add(Message $message)
	{
		$sql = "INSERT INTO Message(text, id_topic, id_membre, id_forum, date) VALUES(:text, :id_topic, :id_membre, :id_forum, :date)";
		
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
			'text' => $message->text(),
			'id_topic' => $message->topic()->id(),
			'id_forum' => $message->forum()->id(),
			'id_membre' => $message->membre()->id(),
			'date' => $message->date()->format('Y-m-d H:i:s')
		));
	}
	
	public function getOne($idMsg)
	{
		$sql = "SELECT m.id as m_id, m.text as m_text, m.date as m_date, 
				mem1.id as mem1_id, mem1.pseudo as mem1_pseudo, mem1.pass as mem1_pass, mem1.img as mem1_img, mem1.signature as mem1_signature,  
				mem2.id as mem2_id, mem2.pseudo as mem2_pseudo, 
				t.id as t_id, t.nom as t_nom,
				f.id as f_id, f.nom as f_nom
				FROM message m 
				LEFT JOIN membre mem2 ON (m.id_membreedit = mem2.id) 
				INNER JOIN membre mem1 ON (m.id_membre = mem1.id) 
				INNER JOIN (topic t INNER JOIN forum f ON t.id_forum = f.id) ON (m.id_topic = t.id) 
				WHERE m.id = :id
				ORDER BY m.id";
		
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
			'id' => $idMsg
		));
		
		$row = $requete->fetch(\PDO::FETCH_ASSOC);
		$msg = new Message();
		$msg->setId($row['m_id']);
		$msg->setText($row['m_text']);
		$msg->setDate(new \DateTime($row['m_date']));
		
		$auteur = new Membre();
		$auteur->setId($row['mem1_id']);
		$auteur->setPseudo($row['mem1_pseudo']);
		$auteur->setPass($row['mem1_pass']);
		$auteur->setImg($row['mem1_img']);
		$auteur->setSignature($row['mem1_signature']);
		
		$msg->setMembre($auteur);
		
		$topic = new Topic();
		$topic->setId($row['t_id']);
		$topic->setNom($row['t_nom']);
		
		$forum = new Forum();
		$forum->setId($row['f_id']);
		$forum->setNom($row['f_nom']);
		
		$topic->setForum($forum);
		$msg->setForum($forum);
		
		$msg->setTopic($topic);
		
		if($row['mem2_id'])
		{
			$edit = new Membre();
			$edit->setId($row['mem2_id']);
			$edit->setPseudo($row['mem2_pseudo']);
			
			$msg->setMembreEdit($edit);
		}
		
		return $msg;
		
	}
	
	public function modify(Message $message)
	{
		$sql = "UPDATE message
				SET text = :text,
				id_membreedit = :membreedit
				WHERE id = :id";
				
		$requete = $this->dao->prepare($sql);
		
		$requete->execute(array(
			'text' => $message->text(),
			'id' => $message->id(),
			'membreedit' => ($message->membreEdit() ? $message->membreEdit()->id() : -1)
		));
	}
}