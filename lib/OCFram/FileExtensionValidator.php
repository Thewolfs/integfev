<?php 
namespace OCFram;

class FileExtensionValidator extends Validator
{
  protected $extension = [];
  
  public function __construct($errorMessage, $extension)
  {
    parent::__construct($errorMessage);
    
    $this->setExtension($extension);
  }
  
  public function isValid($value)
  {
    return in_array(strrchr($value['name'], '.'), $this->extension);
  }
  
  public function setExtension($extension)
  {
	if(is_array($extension))
		$this->extension = $extension;
	else
		throw new \RuntimeException('Les extensions de fichier doivent être contenu dans un array');
  }
}