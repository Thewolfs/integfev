<?php
namespace App\Backend;

use \OCFram\Application;

class BackendApplication extends Application
{
  public function __construct()
  {
    parent::__construct();

    $this->name = 'Backend';
  }

  public function run()
  {
    if ($this->user->isAuthenticated() && $this->user->getAttribute('droit') && $this->user->getAttribute('droit') >= 2)
    {
		$controller = $this->getController();
		$controller->execute();

		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
    }
    else
    {
      $this->httpResponse->redirect('/connexion');
    }
  }
}