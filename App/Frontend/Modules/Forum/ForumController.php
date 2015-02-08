<?php
namespace App\Frontend\Modules\Forum;

use \OCFram\BackController;
use \OCFram\HttpRequest;
use \FormBuilder\ReponseFormBuilder;
use \FormBuilder\ModifierMessageFormBuilder;
use \FormBuilder\NewTextTopicFormBuilder;
use \FormBuilder\NewTitleTopicFormBuilder;
use \FormBuilder\SupprimerMessageFormBuilder;
use \FormBuilder\NewForumFormBuilder;
use \Entity\Message;
use \Entity\Topic;
use \Entity\Forum;
use \Entity\Categorie;

class ForumController extends BackController
{
	public function executeIndex(HttpRequest $request)
	{
		$manager = $this->managers->getManagerOf('Forum');
		
		$listeForum = $manager->getList();
		
		$nbreTopic = $this->managers->getManagerOf('Topic');
		
		$nbreMsg = $this->managers->getManagerOf('Message');;
		
		$this->page->addVar('listeForum', $listeForum);
		$this->page->addVar('nbreTopic', $nbreTopic);
		$this->page->addVar('nbreMsg', $nbreMsg);
		$this->page->addVar('title', "Integ Fev' - Forum");
	}
	
	public function executeShowForum(HttpRequest $request)
	{
		$listeTopic = $this->managers->getManagerOf('Topic')->getList($request->getData('id'));
		
		$nbreMsg = $this->managers->getManagerOf('Message');
		$this->page->addVar('listeTopic', $listeTopic);
		$this->page->addVar('nbreMsg', $nbreMsg);
		$this->page->addVar('idForum', $request->getData('id'));
		$this->page->addVar('title', "Integ Fev' - Forum");
	}
	
	public function executeShowTopic(HttpRequest $request)
	{
		if($request->method() == 'POST')
		{
			$reponse = new Message([
				'text' => $request->postData('text')
			]);
		}
		else
		{
			$reponse = new Message;
		}
		
		$formBuilder = new ReponseFormBuilder($reponse);
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		$listeMsg = $this->managers->getManagerOf('Message')->getList($request->getData('id'));
		
		$reponse->setTopic($listeMsg[0]->topic());
		$reponse->setForum($listeMsg[0]->forum());
		
		$reponse->setDate(new \Datetime());
		if($this->app->user()->getAttribute('pseudo'))
		{
			$pseudo = $this->app->user()->getAttribute('pseudo');
			$membre = $this->managers->getManagerOf('Membre')->getOneByPseudo($pseudo);
			$reponse->setMembre($membre);
			
			$formHandler = new \OCFram\FormHandler($form, $this->managers->getManagerOf('Message'), $request);
			if($formHandler->process())
			{
				$this->app->user()->setFlash('Message publié');
				$this->app->HttpResponse()->redirect('/forum/topic/'.$listeMsg[0]->topic()->id());
			}
		}
		else
		{
			$this->app->user()->setFlash('Veuillez vous connecter');
		}
		
		$this->page->addVar('form', $form->createView());
		$this->page->addVar('listeMsg', $listeMsg);
		$this->page->addVar('title', "Integ Fev' - Forum");
	}
	
	public function executeCreateTopic(HttpRequest $request)
	{
		if($request->method() == 'POST')
		{
			$message = new Message([
				'text' => $request->postData('text')
			]);
			
			$topic = new Topic([
				'nom' => $request->postData('nom')
			]);
			
			
		}
		else
		{
			$message = new Message;
			$topic = new Topic;
		}
		
		$forum = $this->managers->getManagerOf('Forum')->getOne($request->getData('id'));
		
		$topic->setForum($forum);
		$message->setForum($forum);
		$message->setTopic($topic);
		
		$formBuilder1 = new NewTitleTopicFormBuilder($topic);
		$formBuilder1->build();
		
		$formBuilder2 = new NewTextTopicFormBuilder($message);
		$formBuilder2->build();
		
		$form1 = $formBuilder1->form();
		$form2 = $formBuilder2->form();
		
		$formHandler1 = new \OCFram\FormHandler($form1, $this->managers->getManagerOf('Topic'), $request);
		$formHandler2 = new \OCFram\FormHandler($form2, $this->managers->getManagerOf('Message'), $request);
		
		if($pseudo = $this->app->user()->getAttribute('pseudo'))
		{
			if($formHandler1->process())
			{
				$pseudo = $this->app->user()->getAttribute('pseudo');
				$membre = $this->managers->getManagerOf('Membre')->getOneByPseudo($pseudo);
				$message->setMembre($membre);
				$message->setDate(new \Datetime);
				$topicId = $this->managers->getManagerOf('Topic')->getLastIdInsert();
				$topic->setId($topicId);
				if($formHandler2->process())
				{
					$this->app->user()->setFlash('Topic créé');
					$this->app->HttpResponse()->redirect('/forum/'.$forum->id());
				}
				else
				{
					$this->managers->getManagerOf('Topic')->delete($topic);
				}
			}
		}
		else
		{
			$this->app->user()->setFlash('Il faut vous connecter pour pouvoir publier');
			$this->app->HttpResponse()->redirect('/forum/'.$forum->id());
		}
		
		$this->page->addVar('form1', $form1->createView());
		$this->page->addVar('form2', $form2->createView());
		$this->page->addVar('title', 'Integ Fev\' - Créer un nouveau topic' );
	}
	
	public function executeEditMsg(HttpRequest $request)
	{
		$message = $this->managers->getManagerOf('Message')->getOne($request->getData('id'));
		
		if($request->method() == 'POST')
		{
			$message->setText($request->postData('text'));
		}
		
		$formBuilder = new ModifierMessageFormBuilder($message);
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		if($this->app->user()->getAttribute('pseudo'))
		{
			if(($this->app->user()->getAttribute('pseudo') == $message->membre()->pseudo()) || $this->app->user()->getAttribute('droit') >=2)
			{
				$pseudo = $this->app->user()->getAttribute('pseudo');
				$membre = $this->managers->getManagerOf('Membre')->getOneByPseudo($pseudo);
				$message->setMembreEdit($membre);
				$formHandler = new \OCFram\FormHandler($form, $this->managers->getManagerOf('Message'), $request);
				
				if($formHandler->process())
				{
					$this->app->user()->setFlash('Message bien modifié');
					$this->app->HttpResponse()->redirect('/forum/topic/'.$message->topic()->id());
				}
			}
			else
			{
				$this->app->user()->setFlash('Vous ne pouvez pas modifier ce message');
				$this->app->HttpResponse()->redirect('/forum/topic/'.$message->topic()->id());
			}
		}
		else
		{
			$this->app->user()->setFlash('Il faut vous connecter pour pouvoir publier');
			$this->app->HttpResponse()->redirect('/forum/topic/'.$message->topic()->id());
		}
		
		$this->page->addVar('form', $form->createView());
		$this->page->addVar('topicId', $message->topic()->id());
		$this->page->addVar('title', 'Integ Fev\' - Modifier un message');
	}
	
	public function executeDeleteMsg(HttpRequest $request)
	{
		$this->page->addVar('title', 'Integ Fev\' - Supprimer un message');
		$manager = $this->managers->getManagerOf('Message');
		$message = $manager->getOne($request->getData('id'));
		$this->page->addVar('topicId', $message->topic()->id());
		
		if($this->app->user()->getAttribute('droit') >=2)
		{
			$listemsg = $manager->getList($message->topic()->id());
			if($listemsg[0]->id() == $message->id())
			{
				if($request->method() == 'POST')
				{
					$this->managers->getManagerOF('Topic')->delete($message->topic());
					$this->app->user()->setFlash('Topic supprimé');
					$this->app->HttpResponse()->redirect('/forum/'.$message->forum()->id());
				}
			}
			else
			{
				if($request->method()=='POST')
				{
					$message->setText('Message supprimé. Raison : '.$request->postData('text'));
				}
				else
				{
					$message->setText('');
				}
				
				$formBuilder = new SupprimerMessageFormBuilder($message);
				$formBuilder->build();
				
				$form = $formBuilder->form();
				
				
				$formHandler = new \OCFram\FormHandler($form, $this->managers->getManagerOf('Message'), $request);
				var_dump($message->text());
				if($formHandler->process())
				{
					$this->app->user()->setFlash('Message supprimé');
					$this->app->HttpResponse()->redirect('/forum/topic/'.$message->topic()->id());
					
				}
				$this->page->addVar('form', $form->createView());
				
			}
		}
		else
		{
			$this->app->user()->setFlash('Vous n\'avez pas les droits pour supprimer des messages');
			$this->app->HttpResponse()->redirect('/forum/'.$message->forum()->id());
		}
	}
	
	public function executeNewForum(HttpRequest $request)
	{
		$this->page->addVar('title', 'Créer un nouveau forum');
		$listeCateg = $this->managers->getManagerOf('Categorie')->getList();
		$this->page->addVar('listeCateg', $listeCateg);
		if($request->method() == 'POST')
		{
			$forum = new Forum([
				'nom' = $request->postData('nom'),
				'description' = $request->postData('description')
			]);
		}
		else
		{
			$forum = new Forum;
		}
		
		$formBuilder = new NewForumFormBuilder($forum);
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		if($request->postData('choix'))
		{
			$categ = $this->managers->getManagerOf('Categorie')->getOne($request->postData('idcateg'));
			$forum->setCateg($categ);
		}
		else
		{
			$categ = 
		}
		
		$this->page->addVar('form', $form);
		$this->page->addVar('listeCateg', $listeCateg);
	}
}