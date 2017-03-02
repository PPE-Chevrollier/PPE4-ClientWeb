<?php
namespace App\Controleurs
{
	class Accueil extends \Systeme\Controleur
	{
		public function index()
		{
			$this->chargerVue('');
		}
	}
}