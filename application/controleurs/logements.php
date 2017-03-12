<?php
namespace App\Controleurs
{
	class Logements extends \Systeme\Controleur
	{
		public function index()
		{
			$this->chargerVue('', ['titre' => 'Liste des logements']);
		}
	}
}