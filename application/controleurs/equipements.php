<?php
namespace App\Controleurs
{
	class Equipements extends \Systeme\Controleur
	{
		public function ajouter($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('equipements');
			$this->chargerModele('logements');
			$this->chargerValidateur('equipements');
			$idLogement = (sizeof($params) == 1) ? $params[0] : 0;
			$logement = $this->logements->recupParId($idLogement);
			if ($logement == null)
				$this->chargerVue('introuvable', ['titre' => 'Logement introuvable']);
			else if ($logement->id_etudiants != $this->session->recup('id_etudiants'))
				$this->chargerVue('interdit', ['titre' => 'Opération interdite']);
			else
			{
				if ($this->validateurEquipements->ajouter())
				{
					$idEquipement = 0;
					$equipement = $this->equipements->recup($this->validateurEquipements->recupValeur('libelle_equipements'));
					if ($equipement == null)
						$idEquipement = $this->equipements->ajouter($this->validateurEquipements->recupValeur('libelle_equipements'));
					else
						$idEquipement = $equipement->id_equipements;
					$this->logements->ajouterEquipement($idLogement, $idEquipement);
					$this->rediriger('logements', 'equipements', [$idLogement]);
				}
				else
					$this->chargerVue('', ['scripts' => ['equipements'], 'titre' => 'Ajouter un équipement']);
			}
		}
		
		public function supprimer($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('equipements');
			$this->chargerModele('logements');
			$idLogement = (sizeof($params) == 2) ? $params[0] : 0;
			$idEquipement = (sizeof($params) == 2) ? $params[1] : 0;
			$logement = $this->logements->recupParId($idLogement);
			if ($logement == null)
				$this->chargerVue('introuvable', ['titre' => 'Logement introuvable']);
			else if ($logement->id_etudiants != $this->session->recup('id_etudiants'))
				$this->chargerVue('interdit', ['titre' => 'Opération interdite']);
			else
			{
				$this->logements->supprimerEquipement($idLogement, $idEquipement);
				$this->rediriger('logements', 'equipements', [$idLogement]);
			}
		}
	}
}