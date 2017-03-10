<?php
namespace App\Services
{
	class Connexion extends \Systeme\Service
	{
		public function __construct($routeur, $session)
		{
			parent::__construct($routeur, $session);
			$this->modeles = ['personnes'];
		}

		public function traiter()
		{
			if (!$this->session->recup('id_personnes'))
			{
				$this->session->definir('messageConnexion', 'Veuillez vous connecter pour accéder à cette page.');
				$this->session->definir('url_temp', [$this->routeur->recupNomControleur(), $this->routeur->recupNomAction(), $this->routeur->recupParams()]);
				$this->routeur->rediriger('connexion');
			}
			$this->session->supprimer('messageConnexion');
		}
	}
}