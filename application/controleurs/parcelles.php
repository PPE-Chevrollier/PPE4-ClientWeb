<?php
namespace App\Controleurs
{
	class Parcelles extends \Systeme\Controleur
	{
		public function ajouter()
		{
			$this->verifierConnexion();
			$this->chargerModele('parcelle');
			$this->chargerModele('planter');
			$this->chargerValidateur('parcelle');
			if ($this->validateurParcelle->ajouter($this->session->recup('id_champ')))
			{
				$this->parcelle->inserer(['nom_parcelle' => $this->validateurParcelle->recupValeur('nom_parcelle'), 'superficie_parcelle' => $this->validateurParcelle->recupValeur('superficie_parcelle'), 'id_champ' => $this->session->recup('id_champ'), 'id_plante' => $this->validateurParcelle->recupValeur('id_plante'), 'id_terrain' => 1]);
				$this->rediriger('parcelles');
			}
			else
			{
				$this->chargerModele('plante');
				$plantes = $this->plante->recup([], ['ordre' => ['nom_plante' => 'croissant']]);
				$plantes2 = [];
				foreach ($plantes as $p)
					array_push($plantes2, [$p['id_plante'], $p['nom_plante']]);
				$this->chargerModele('type-terrain');
				$terrains = $this->typeTerrain->recup([], ['ordre' => ['nom_terrain' => 'croissant']]);
				$terrains2 = [];
				foreach ($terrains as $t)
					array_push($terrains2, [$t['id_terrain'], $t['nom_terrain']]);
				$this->chargerVue('', ['titre' => 'Ajouter une parcelle', 'plantes' => $plantes2, 'terrains' => $terrains2]);
			}
		}
		
		public function index()
		{
			$this->verifierConnexion();
			$this->chargerModele('parcelle');
			$this->chargerVue('', ['titre' => 'Mon champ', 'parcelles' => $this->parcelle->recup(['id_champ' => $this->session->recup('id_champ')], ['ordre' => ['nom_parcelle' => 'croissant']], ['id_plante' => 'plante.id_plante'])]);
		}
	}
}