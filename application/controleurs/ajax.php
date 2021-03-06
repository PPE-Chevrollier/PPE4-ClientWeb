<?php
namespace App\Controleurs
{
	class Ajax extends \Systeme\Controleur
	{
		public function recupEquipements($params)
		{
			$this->chargerModele('equipements');
			$equipements = $this->equipements->recherche($params[0]);
			$tabEquipements = array();
			foreach ($equipements as $equipement)
				array_push($tabEquipements, $equipement->libelle_equipements);
			echo json_encode($tabEquipements);
		}
		
		public function recupEtudiants($params)
		{
			$this->chargerModele('personnes');
			$etudiants = $this->personnes->recherche($params[0]);
			$tabEtudiants = [];
			foreach ($etudiants as $e)
				array_push($tabEtudiants, ['nom' => $e->nom_etudiants, 'nomUtilisateur' => $e->login_etudiants, 'prenom' => $e->prenom_etudiants, 'sexe' => $e->sexe_etudiants]);
			echo json_encode($tabEtudiants);
		}
		
		public function recupVilles($params)
		{
			$this->chargerModele('villes');
			$villes = $this->villes->recherche($params[0]);
			$tabVilles = array();
			foreach ($villes as $ville)
				array_push($tabVilles, $ville->nom_villes);
			echo json_encode($tabVilles);
		}
                
		public function recupProprietaires($params)
		{
			$this->chargerModele('proprietaires');
			echo json_encode($this->proprietaires->recherche($params[0]));
		}
                
		public function recupMotifs($params){
			$this->chargerModele('motifs');
			$motifs = $this->motifs->recherche($params[0]);
			$tabMotifs = array();
			foreach ($motifs as $motif)
				array_push($tabMotifs, $motif->libelle_motifs);
			echo json_encode($tabMotifs);
		}
	}
}