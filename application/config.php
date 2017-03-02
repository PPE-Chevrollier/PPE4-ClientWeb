<?php
namespace application
{
	class Config extends \systeme\Config
	{
		public function __construct()
		{
			parent::__construct();
			$this->definir('hote', '192.168.152.2');
			$this->definir('nomBDD', 'bd_ppe_test');
			$this->definir('nomUtilisateur', 'ppe');
			$this->definir('mdpBDD', 'Azerty123');
		}
	}
}