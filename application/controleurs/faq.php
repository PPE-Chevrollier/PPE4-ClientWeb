<?php
namespace App\Controleurs
{
	class Faq extends \Systeme\Controleur
	{
		public function index()
		{
			$this->chargerVue('', ['titre' => 'FAQ']);
		}
	}
}