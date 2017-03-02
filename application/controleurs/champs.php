<?php
namespace App\Controleurs
{
	class Champs extends \Systeme\Controleur
	{
		public function ajouter()
		{
			$this->chargerModele('champ');
			$this->chargerValidateur('champ');
			if ($this->validateurChamp->ajouter())
			{
				$this->champ->inserer(['nom_champ' => $this->validateurChamp->recupValeur('nom_champ'), 'mdp_champ' => $this->validateurChamp->recupValeur('mdp_champ')]);
				$this->session->definir('inscrit', true);
				$this->rediriger('connexion');
			}
			else
				$this->chargerVue('', ['titre' => 'Inscription']);
		}
	}
}