<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\PassField;
use \OCFram\TextField;
use \OCFram\FileField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;
use \OCFram\FileExtensionValidator;
use \OCFram\MaxSizeValidator;

class ModifierFormBuilder extends FormBuilder
{
	public function build()
	{
		$this->form->add(new StringField([
			'label' => 'Pseudo',
			'name' => 'pseudo',
			'maxLength' => 25,
			'validators' => [
				new MaxLengthValidator("Pseudo trop long", 20),
				new NotNullValidator('Il faut rentrer un pseudo')
			]
		]));
		
		$this->form->add(new PassField([
			'label' => 'Mot de Passe',
			'name' => 'pass',
			'maxLength' => 100,
			'validators' => [
				new MaxLengthValidator("Mot de passe trop long", 100),
				new NotNullValidator('Il faut rentrer un mot de passe')
			]
		]));
		
		$this->form->add(new FileField([
			'label' => 'Image (png, jpg, gif inférieure à 2MO)',
			'name' => 'img'
		]));
		
		$this->form->add(new TextField([
			'label' => 'Signature',
			'name' => 'signature',
			'rows' => 10,
			'validators' => [
				new MaxLengthValidator("Signature trop longue", 500)
			]
		]));
	}
}