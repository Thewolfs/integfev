<?php 
namespace App\Frontend\Modules\General;

use \OCFram\BackController;
use \OCFram\HttpRequest;

class GeneralController extends BackController
{
	public function executeIndex(HttpRequest $request)
	{
		$bio = '';
		$text = fopen('uploads/bio.txt', 'r+');
		while(!feof($text))
		{
			$bio = $bio.fgets($text);				
		}
		fclose($text);
		
		$this->page->addVar('bio', $bio);
		$this->page->addVar('title', "Integ Fev' - Accueil");
	}
	
	public function executeShowPlanning(HttpRequest $request)
	{
		$table = array(array());
		$row = 0;
		if (($handle = fopen("uploads/planning.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
					for ($c=0; $c < $num; $c++) {
						$table[$row][$c] = $data[$c];
					}
				$row++;
			}
			fclose($handle);
		}
		$this->page->addVar('table', $table);
		$this->page->addVar('title', "Integ Fev' - Planning");
	}
	
	public function executeShowFaq(HttpRequest $request)
	{
		$manager = $this->managers->getManagerOf('Faq');
		
		$listeFaq = $manager->getList();
		
		$this->page->addVar('listeFaq', $listeFaq);
		$this->page->addVar('title', "Integ Fev' - FAQ");
	}
}