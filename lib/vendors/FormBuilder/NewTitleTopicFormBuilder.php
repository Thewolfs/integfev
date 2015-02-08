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

class NewTitleTopicFormBuilder extends FormBuilder
{
	public function build()
	{
		$this->form->add(new StringField([
			'label' => 'Titre du topic',
			'name' => 'nom',
			'maxLength' => 255,
			'validators' => [
				new NotNullValidator('Il faut rentrer un titre'),
				new MaxLengthValidator('Le titre ne doit pas faire plus de 255 caractères', 255)
			]
		]));
	}
}