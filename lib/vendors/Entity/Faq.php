<?php
namespace Entity;

use \OCFram\Entity;

class Faq extends Entity
{
	protected 	$question,
				$text;
				
	const QUESTION_INVALIDE = 1;
	const TEXT_INVALIDE = 2;
	
	public function isValid()
	{
		return !(empty($this->question) || empty($this->text));
	}
	
	// SETTERS //
	
	public function setQuestion($question)
	{
		if(!is_string($question) || empty($question))
			$this->erreurs[] = self::QUESTION_INVALIDE;
		
		$this->question = htmlspecialchars($question);
	}
	
	public function setText($text)
	{
		if(!is_string($text) || empty($text))
			$this->erreurs[] = self::TEXT_INVALIDE;
		
		$this->text = htmlspecialchars($text);
	}
	
	// GETTERS //
	
	public function question()
	{
		return $this->question;
	}
	
	public function text()
	{
		return $this->text;
	}
}