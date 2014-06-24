<?php

class Users extends \Phalcon\Mvc\Model
{

	public function initialize()
	{
		$this->setSource("weic_admin_user");
	}

}