<?php
namespace App\Controleurs
{
	class Erreurs extends \Systeme\Controleur
	{
		public function erreurAction($params)
		{
			$this->chargerVue('', ['titre' => 'Erreur 404', 'nomControleur' => $params[0], 'nomAction' => $params[1]]);
		}
		
		public function erreurBdd($params)
		{
			$this->chargerVue('', ['titre' => 'Erreur de connexion à la base de données',]);
		}
	
		public function erreurControleur($params)
		{
			$this->chargerVue('', ['titre' => 'Erreur 404', 'nomControleur' => $params[0]]);
		}
		
		public function erreurVue($params)
		{
			$this->chargerVue('', ['titre' => 'Erreur 404', 'nomVue' => $params[0]]);
		}
	}
}