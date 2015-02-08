<?php
namespace App\Frontend\Modules\Membre;

use \OCFram\BackController;
use \OCFram\HttpRequest;
use \FormBuilder\ConnexionFormBuilder;
use \FormBuilder\InscriptionFormBuilder;
use \FormBuilder\ModifierFormBuilder;
use \Entity\Membre;

class MembreController extends BackController
{
	public function executeConnexion(HttpRequest $request)
	{
		$this->page->addVar('title', "Integ Fev' - Connexion");
		if($request->method() == 'POST')
		{
			$connexion = New Membre([
				'pseudo' => $request->postData('pseudo'),
				'pass' => $request->postData('pass')
			]);
		}
		else
		{
			$connexion = new Membre;
		}
		
		$formBuilder = new ConnexionFormBuilder($connexion);
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		if($request->method() == 'POST' && $form->isValid())
		{
			$pseudo = htmlspecialchars($connexion->pseudo());
			$pass = hash('sha256', htmlspecialchars($connexion->pass()));
			
			$manager = $this->managers->getManagerOf('Membre');
			
			$membre = $manager->getOneByPseudo($pseudo);
			
			if($membre->pass() == $pass)
			{
				$this->app->user()->setAuthenticated(true);
				$this->app->user()->setAttribute('droit', $membre->droit());
				$this->app->user()->setAttribute('pseudo', $membre->pseudo());
				$this->app->user()->setFlash('Vous êtes bien connecté');
				$this->app->HttpResponse()->redirect('.');
			}
			else
			{
				$this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect.');
			}
		}
		$this->page->addVar('form', $form->createView());
	}
	
	public function executeInscription(HttpRequest $request)
	{
		$this->page->addVar('title', "Integ Fev' - Inscription");
		$rpass_error = '';
		
		if($request->method() == 'POST')
		{
			$inscription = New Membre([
				'pseudo' => $request->postData('pseudo'),
				'pass' => $request->postData('pass')
			]);
		}
		else
		{
			$inscription = new Membre;
		}
		
		$formBuilder = new InscriptionFormBuilder($inscription);
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		if(htmlspecialchars($request->postData('rpass')) == $inscription->pass())
		{
			$formHandler = new \OCFram\FormHandler($form, $this->managers->getManagerOf('Membre'), $request);
			
			if($this->managers->getManagerOf('Membre')->getOneByPseudo($inscription->pseudo())->pseudo())
				$this->app->user()->setFlash('Pseudo déjà existant, veuillez le modifier');
			else
			{
				$inscription->setPass(hash('sha256', $inscription->pass()));
				if($formHandler->process())
				{
					$this->app->user()->setFlash('Vous avez bien été inscrit, veuillez vous connecter');
					$this->app->HttpResponse()->redirect('.');
				}
			}
		}
		else
		{
			$rpass_error = 'Les mots de passe ne sont pas identiques<br />';
		}
		$this->page->addVar('form', $form->createView());
		$this->page->addVar('rpass_error', $rpass_error);
	}
	
	public function executeDeconnexion(HttpRequest $request)
	{
		$this->app->user()->setFlash('Vous avez bien été déconnecter');
		$this->app->user()->setAuthenticated(false);
		$this->app->user()->setAttribute('droit', 0);
		$this->app->HttpResponse()->redirect('.');
	}
	
	public function executeShowMembre(HttpRequest $request)
	{
		$membre = new Membre;
		$this->page->addVar('title', "Integ Fev' - Membre");
		
		if($request->method() == 'POST')
		{
			if(empty($request->postData('pseudo')))
			{
				$this->app->user()->setFlash('Veuillez rentrer un pseudo');
			}
			else
			{
				$pseudo = htmlspecialchars($request->postData('pseudo'));
				$manager = $this->managers->getManagerOf('Membre');
				$membre = $manager->getOneByPseudo($pseudo);
				
				$this->page->addVar('membre', $membre);
				$this->page->addVar('stitre', 'Le membre recherché est :');
				$this->page->addVar('links', '');
			}
		}
		else
		{
			$this->page->addVar('stitre', 'Vous êtes :');
			
			$pseudo = $this->app->user()->getAttribute('pseudo');
			$manager = $this->managers->getManagerOf('Membre');
			$membre = $manager->getOneByPseudo($pseudo);
			
			$this->page->addVar('membre', $membre);
			$this->page->addVar('links', '<a href="/modifier">Modifier ses infos</a><br />');
		}
	}
	
	public function executeModifier(HttpRequest $request)
	{
		$this->page->addVar('title', "Integ Fev' - Modifier");
		
		$fileError = '';
		
		$pseudo = $this->app->user()->getAttribute('pseudo');
		$manager = $this->managers->getManagerOf('Membre');
		$modif = $manager->getOneByPseudo($pseudo);
		$pass = $modif->pass();
		
		if($request->method() == 'POST')
		{
			$modif->setPseudo($request->postData('pseudo'));
			$modif->setPass($request->postData('pass'));
			$modif->setSignature($request->postData('signature'));
		}
		
		$formBuilder = new ModifierFormBuilder($modif);
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		if($request->method() == 'POST')
			$modif->setPass(hash('sha256', $request->postData('pass')));
		
		if($request->method() == 'POST' && $form->isValid() && $pass == $modif->pass() && ($modif->pseudo() == $pseudo || !$manager->getOneByPseudo($modif->pseudo())->pseudo()) && $request->postData('npass') == $request->postData('rpass'))
		{
			if($request->postData('npass'))
				$modif->setPass(hash('sha256', $request->postData('npass')));
			
			$fileSuccess = false;
			if($request->fileData('img')['name'])
			{
				$img = $request->fileData('img');
				$taillemaxi = 2097152;
				$taille = filesize($img['tmp_name']);
				$extension = strrchr($img['name'], '.');
				$extallowed = [
					'.png',
					'.jpg',
					'.gif'
				];
				
				$dossier = 'uploads/imgmembre/';
				
				if(in_array($extension, $extallowed))
				{
					if($taille <= $taillemaxi)
					{
						$tailles = getimagesize($img['tmp_name']);
						
						if($tailles[0] == $tailles[1])
						{
							if(move_uploaded_file($img['tmp_name'], $dossier.$modif->pseudo().$extension))
							{
								$modif->setImg($modif->pseudo().$extension);
								$fileSuccess = true;
							}
						}
						else
						{
							$this->app->user()->setFlash('L\'image n\'est pas carrée');
						}
					}
					else
					{
						$this->app->user()->setFlash('Fichier trop volumineux (2 Mo max)');
					}
				}
				else
				{
					$this->app->user()->setFlash('Fichier de type incorrect');
				}
			}
			else
			{
				$fileSuccess = true;
			}
			
			$formHandler = new \OCFram\FormHandler($form, $this->managers->getManagerOf('Membre'), $request);
			
			if($fileSuccess && $formHandler->process())
			{
				$this->app->user()->setAttribute('pseudo', $modif->pseudo());
				$this->app->user()->setFlash('Modification réussi');
				$this->app->HttpResponse()->redirect('/membre');
			}
		}
		else
		{
			if(!($modif->pseudo() == $pseudo || !$manager->getOneByPseudo($modif->pseudo())->pseudo()))
				$this->app->user()->setFlash('Pseudo déjà existant');
			if($pass != $modif->pass())
				$this->app->user()->setFlash('Mot de passe incorrect');
		}
		
		$this->page->addVar('form', $form->createView());
	}
}