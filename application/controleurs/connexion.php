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
				$this->session->definir('id_personnes', $this->validateurPersonnes->recupValeur('id_personnes'));
				$this->session->definir('prenom_personnes', $this->validateurPersonnes->recupValeur('prenom_personnes'));
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