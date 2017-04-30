<?php
namespace App
{
	class Config extends \systeme\Config
	{
		public function __construct()
		{
			parent::__construct();
			$this->definir('hote', 'localhost');
			$this->definir('nomBDD', 'bd_ppe');
			$this->definir('nomUtilisateur', 'chevloc');
			$this->definir('mdpBDD', 'chevloc123');
		}
	}
}