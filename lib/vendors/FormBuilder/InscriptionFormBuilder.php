<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\PassField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class InscriptionFormBuilder extends FormBuilder
{
	public function build()
	{
		$this->form->add(new StringField([
			'label' => 'Pseudo',
			'name' => 'pseudo',
			'maxLength' => 20,
			'validators' => [
				new MaxLengthValidator("Pseudo trop long", 20),
				new NotNullValidator('Il faut rentrer un pseudo')
			]
		]));
		
		$this->form->add(new PassField([
			'label' => 'Mot de Passe',
			'name' => 'pass',
			'maxLength' => 50,
			'validators' => [
				new MaxLengthValidator("Mot de passe trop long", 50),
				new NotNullValidator('Il faut rentrer un mot de passe')
			]
		]));
	}
}