<?php
namespace Systeme
{
	abstract class Service
	{
		protected $modeles;
		protected $routeur;
		protected $session;
		
		public function __construct($routeur, $session)
		{
			$this->routeur = $routeur;
			$this->session = $session;
		}
		
		public function definirModele($nom, $objet)
		{
			$this->$nom = $objet;
		}
		
		public function recupModeles()
		{
			return $this->modeles;
		}
		
		public function traiter()
		{
			if (!$this->session->recup('id_etudiants'))
			{
				$this->session->definir('url_temp', [$this->routeur->recupNomControleur(), $this->routeur->recupNomAction(), $this->routeur->recupParams()]);
				$this->routeur->rediriger('connexion');
			}
		}
	}
}