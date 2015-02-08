<?php
namespace OCFram;

class FileField extends Field
{
	public function buildWidget()
	{
		$widget = '';

		if (!empty($this->errorMessage))
		{
		  $widget .= $this->errorMessage.'<br />';
		}

		$widget .= '<div class="form-group"><label for="'.$this->name.'">'.$this->label.' :</label><input class="form-control" type="file" name="'.$this->name.'"';

		return $widget .= ' /></div>';
	}
}