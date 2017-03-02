<?php
namespace App\Controleurs
{
	class Plantes extends \Systeme\Controleur
	{
		public function index($params)
		{
			$this->chargerModele('plante');
			$this->pagination->definirNbElements($this->plante->compter());
			$this->chargerVue('', ['titre' => 'Liste des plantes', 'plantes' => $this->plante->recupPage($this->pagination->recupPage())]);
		}
		
		public function voir($params)
		{
			$this->chargerModele('plante');
			$plante = $this->plante->recup(['id_plante' => $params[0]])[0];
			$this->chargerVue('', ['titre' => 'Détails de la plante ' . $plante['nom_plante'], 'plante' => $plante]);
		}
	}
}