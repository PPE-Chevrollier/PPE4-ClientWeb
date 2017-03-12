<?php
namespace App\Services
{
	class Connexion extends \Systeme\Service
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
			if ($this->session->recup('id_personnes'))
			{
				$this->personne = $this->personnes->recupParID($this->session->recup('id_personnes'));
				if ($this->personne != null)
				{
					$this->session->supprimer('messageConnexion');
					return;
				}
			}
			$this->session->definir('messageConnexion', 'Veuillez vous connecter pour accéder à cette page.');
			$this->session->definir('url_temp', [$this->routeur->recupNomControleur(), $this->routeur->recupNomAction(), $this->routeur->recupParams()]);
			$this->routeur->rediriger('connexion');
		}
	}
}