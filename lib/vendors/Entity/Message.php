<?php
namespace Entity;

use OCFram\Entity;

class Message extends Entity
{
	protected 	$text,
				$topic,
				$membre,
				$forum,
				$date,
				$membreEdit;
				
	const TEXT_INVALIDE = 1;
	
	public function isValid()
	{
		return !(empty($this->text) || empty($this->topic) || empty($this->forum) || empty($this->date));
	}
	
	// SETTERS //
	
	public function setText($text)
	{
		if(empty($text) || !is_string($text))
			$this->erreurs[] = self::TEXT_INVALIDE;
		
		$this->text = htmlspecialchars($text);
	}
	
	public function setTopic(Topic $topic)
	{
		$this->topic = $topic;
	}
	
	public function setMembre(Membre $membre)
	{		
		$this->membre = $membre;

	}
	
	public function setForum(Forum $forum)
	{		
		$this->forum = $forum;
	}
	
	public function setDate(\DateTime $date)
	{		
		$this->date = $date;
	}
	
	public function setMembreEdit($membreEdit)
	{
		$this->membreEdit = $membreEdit;
	}
	
	// GETTERS //
	
	public function text()
	{
		return $this->text;
	}
	
	public function topic()
	{
		return $this->topic;
	}
	
	public function membre()
	{
		return $this->membre;
	}
	
	public function forum()
	{
		return $this->forum;
	}
	
	public function date()
	{
		return $this->date;
	}
	
	public function membreEdit()
	{
		return $this->membreEdit;
	}
}