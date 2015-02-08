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

class ReponseFormBuilder extends FormBuilder
{
	public function build()
	{
		$this->form->add(new TextField([
			'label' => 'Réponse',
			'name' => 'text',
			'rows' => 10,
			'validators' => [
				new NotNullValidator('Il faut rentrer un message')
			]
		]));
	}
}