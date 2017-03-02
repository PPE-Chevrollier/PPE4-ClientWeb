<?php
namespace App\Controleurs
{
	class APropos extends \Systeme\Controleur
	{
		public function index()
		{
			$this->chargerVue('', ['titre' => 'A propos']);
		}
	}
}