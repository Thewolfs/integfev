<?php
namespace Model;

use \Entity\Faq;

class FaqManagerPDO extends FaqManager
{
	public function getList()
	{
		$sql = "SELECT * FROM faq";
		
		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Faq');
		
		$listeFaq = $requete->fetchAll();
		
		$requete->closeCursor();
		
		return $listeFaq;
	}
}