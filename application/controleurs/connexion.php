<?php
namespace App\Controleurs
{
	class Connexion extends \Systeme\Controleur
	{
		public function deconnexion()
		{
			$this->session->vider();
			$this->rediriger();
		}
		
		public function index()
		{
			$this->chargerModele('personnes');
			$this->chargerValidateur('personnes');
			if ($this->validateurPersonnes->connecter())
			{
				$this->session->definir('id_etudiants', $this->validateurPersonnes->recupValeur('id_etudiants'));
				$this->session->definir('prenom_etudiants', $this->validateurPersonnes->recupValeur('prenom_etudiants'));
                                $this->session->definir('login_etudiants', $this->validateurPersonnes->recupValeur('login_etudiants'));
				$url = $this->session->recup('url_temp');
				$this->session->supprimer('url_temp');
				$nomControleur = '';
				$nomAction = '';
				$params = [];
				if (isset($url[0]))
					$nomControleur = $url[0];
				if (isset($url[1]))
					$nomAction = $url[1];
				if (isset($url[2]))
					$params = $url[2];
				$this->rediriger($nomControleur, $nomAction, $params);
			}
			else
			{
				$this->chargerVue('', ['titre' => 'Connexion']);
				$this->session->supprimer('messageConnexion');
			}
		}
	}
}