<?php
namespace App\Validateurs
{
	class Equipements extends \Systeme\Validateur
	{
		public function __construct($controleur, $modele)
		{
			parent::__construct($controleur, $modele);
			$this->ajouterChamp(['nom' => 'libelle_equipements', 'type' => 'texte', 'libelle' => 'Nom de l\'équipement']);
		}
	}
}