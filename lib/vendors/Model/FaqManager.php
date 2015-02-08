<?php
namespace Model;

use \OCFram\Manager;

abstract class FaqManager extends Manager
{
	abstract public function getList();
}