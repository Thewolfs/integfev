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

class NewForumFormBuilder extends FormBuilder
{
	public function build()
	{
		$this->form->add(new StringField([
			'label' => 'Titre du nouveau forum',
			'name' => 'nom',
			'maxLength' => 25,
			'validators' => [
				new NotNullValidator('Il faut rentrer un nom'),
				new MaxLengthValidator('Le nom de forum ne doit pas faire plus de 25 caractères', 25)
			]
		]));
		
		$this->form->add(new TextField([
			'label' => 'Description',
			'name' => 'description',
			'rows' => 10,
			'validators' => [
				new NotNullValidator('Il faut rentrer une description')
			]
		]));
	}
}