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
			$this->chargerModele('champ');
			$this->chargerValidateur('champ');
			if ($this->validateurChamp->connecter())
			{
				$this->session->supprimer('inscrit');
				$this->session->definir('id_champ', $this->validateurChamp->recupValeur('id_champ'));
				$this->session->definir('nom_champ', $this->validateurChamp->recupValeur('nom_champ'));
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
				$this->chargerVue('', ['titre' => 'Connexion']);
		}
	}
}