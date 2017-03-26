<?php
namespace App\Validateurs
{
	class Photos extends \Systeme\Validateur
	{
		public function __construct($controleur, $modele)
		{
			parent::__construct($controleur, $modele);
			$this->ajouterChamp(['nom' => 'description_photos', 'type' => 'texte', 'libelle' => 'Description de la photo']);
		}
		
		public function ajouter()
		{
			$this->ajouterChamp(['nom' => 'photo', 'type' => 'fichier', 'extensions' => ['jpg', 'bmp', 'png'], 'libelle' => 'Photo']);
			return $this->estValide();
		}
		
		public function modifier()
		{
			return $this->estValide();
		}
	}
}