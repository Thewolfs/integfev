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

class SupprimerMessageFormBuilder extends FormBuilder
{
	public function build()
	{
		$this->form->add(new StringField([
			'label' => 'Raison de la suppression',
			'name' => 'text',
			'maxLength' => 52,
			'validators' => [
				new NotNullValidator('Il faut rentrer un message'),
				new MaxLengthValidator('La raison ne doit pas faire plus de 25 caractères', 52)
			]
		]));
	}
}