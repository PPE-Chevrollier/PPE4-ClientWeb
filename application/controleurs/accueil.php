<?php
namespace App\Controleurs
{
	class Accueil extends \Systeme\Controleur
	{
		public function index()
		{
			$this->chargerModele('logements');
			$logements = $this->logements->recup5Derniers();
			$this->chargerVue('', ['logements' => $logements]);
		}
	}
}