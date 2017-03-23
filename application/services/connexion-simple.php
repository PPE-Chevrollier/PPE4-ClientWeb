<?php
namespace App\Services
{
	class ConnexionSimple extends \Systeme\Service
	{
		private $personne;
		
		public function __construct($routeur, $session)
		{
			parent::__construct($routeur, $session);
			$this->modeles = ['personnes'];
		}

		public function recupPersonne()
		{
			return $this->personne;
		}
		
		public function traiter()
		{
			if ($this->session->recup('id_etudiants'))
				$this->personne = $this->personnes->recupParID($this->session->recup('id_etudiants'));
		}
	}
}