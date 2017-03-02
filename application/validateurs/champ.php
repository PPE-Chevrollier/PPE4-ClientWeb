<?php
namespace App\Validateurs
{
	class Champ extends \Systeme\Validateur
	{
		public function __construct($controleur, $modele)
		{
			parent::__construct($controleur, $modele);
			$this->ajouterChamp(['nom' => 'nom_champ', 'label' => 'Nom d\'utilisateur']);
			$this->ajouterChamp(['nom' => 'mdp_champ', 'label' => 'Mot de passe']);
		}
		
		public function ajouter()
		{
			$this->ajouterChamp(['nom' => 'confirmation_mdp', 'type' => 'motdepasse', 'label' => 'Confirmation du mot de passe']);
			if (parent::ajouter())
			{
				if ($this->recupValeur('mdp_champ') != $this->recupValeur('confirmation_mdp'))
					$this->definirErreur('confirmation_mdp', 'La confirmation du mot de passe est incorrect.');
				else
				{
					$existant = $this->modele->recup(['nom_champ' => $this->recupValeur('nom_champ')]);
					if ($existant)
						$this->definirErreur('nom_champ', 'Ce nom d\'utilisateur n\'est pas disponible.');
					else
						return true;
				}
			}
		}
		
		public function connecter()
		{
			if (parent::estValide())
			{
				$champ = $this->modele->recup(['nom_champ' => $this->recupValeur('nom_champ')]);
				if (!$champ)
					$this->definirErreur('nom_champ', 'Ce nom d\'utilisateur n\'existe pas.');
				else if ($champ[0]['mdp_champ'] != $this->recupValeur('mdp_champ'))
					$this->definirErreur('mdp_champ', 'Le mot de passe est incorrect.');
				else
				{
					$this->definirValeur('id_champ', $champ[0]['id_champ']);
					return true;
				}
			}
		}
	}
}