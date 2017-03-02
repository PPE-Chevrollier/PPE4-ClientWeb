<?php
namespace App\Validateurs
{
	class Parcelle extends \Systeme\Validateur
	{
		public function __construct($controleur, $modele)
		{
			parent::__construct($controleur, $modele);
			$this->ajouterChamp(['nom' => 'superficie_parcelle', 'label' => 'Superficie de la parcelle']);
			$this->ajouterChamp(['nom' => 'nom_parcelle', 'label' => 'Nom de la parcelle']);
			$this->ajouterChamp(['nom' => 'id_plante', 'requis' => true, 'label' => 'Plante']);
			$this->ajouterChamp(['nom' => 'id_terrain', 'label' => 'Type de terrain']);
		}
		
		public function ajouter()
		{
			if (parent::ajouter())
			{
				$existant = $this->modele->recup(['id_champ' => $this->controleur->recupSession()->recup('id_champ'), 'nom_parcelle' => $this->recupValeur('nom_parcelle')]);
				if ($existant)
					$this->definirErreur('nom_parcelle', 'Vous avez déjà un champ portant ce nom.');
				else
					return true;
			}
		}
	}
}