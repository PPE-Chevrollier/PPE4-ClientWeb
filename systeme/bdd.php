<?php
namespace Systeme
{
	class BDD
	{
		private $connexion;
	
		public function __construct($config)
		{
			$this->connexion = new \PDO('mysql:host=' . $config->recup('hote') . ';dbname=' . $config->recup('nomBDD'), $config->recup('nomUtilisateur'), $config->recup('mdpBDD'));
			$this->connexion->exec("SET CHARACTER SET utf8");
		}
	
		public function recup()
		{
			return $this->connexion;
		}
	}
}