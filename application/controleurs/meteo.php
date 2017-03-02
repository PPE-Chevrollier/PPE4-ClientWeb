<?php
namespace App\Controleurs
{
	class Meteo extends \Systeme\Controleur
	{
		public function index()
		{
			$this->chargerModele('appliquer');
			$this->chargerVue('', ['titre' => 'Météo', 'jours' => $this->appliquer->recupSemaine()]);
		}
		
		public function voir($params)
		{
			$date = strtotime(implode('-', $params));
			$texteDate = date('Y-m-d', $date);
			$this->chargerModele('appliquer');
			$evenements = $this->appliquer->recupJour($texteDate);
			$texteDate = date('d/m/Y', $date);
			$this->chargerVue('', ['titre' => 'Météo du ' . $texteDate, 'date' => $texteDate, 'evenements' => $evenements]);
		}
	}
}