<?php
namespace App\Services
{
	require_once('connexion-simple.php');
	class Connexion extends ConnexionSimple
	{
		public function __construct($routeur, $session)
		{
			parent::__construct($routeur, $session);
		}
		
		public function traiter()
		{
			parent::traiter();
			if ($this->recupPersonne() == null)
			{
				$this->session->definir('messageConnexion', 'Veuillez vous connecter pour accéder à cette page.');
				$this->session->definir('url_temp', [$this->routeur->recupNomControleur(), $this->routeur->recupNomAction(), $this->routeur->recupParams()]);
				$this->routeur->rediriger('connexion');
			}
			else
				$this->session->supprimer('messageConnexion');
		}
	}
}