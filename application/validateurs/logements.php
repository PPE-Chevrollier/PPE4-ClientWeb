<?php
namespace App\Validateurs
{
	class Logements extends \Systeme\Validateur
	{
		public function __construct($controleur, $modele)
		{
			parent::__construct($controleur, $modele);			
		}
		
		public function ajouter()
		{			
			$this->ajouterChamp(['nom' => 'nom_proprietaire', 'type' => 'texte', 'libelle' => 'Nom']);
			$this->ajouterChamp(['nom' => 'prenom_proprietaire', 'type' => 'texte', 'libelle' => 'Prénom']);
			$this->ajouterChamp(['nom' => 'sexe_proprietaire', 'type' => 'texte', 'libelle' => 'Civilité']);
			$this->ajouterChamp(['nom' => 'rue_logements', 'type' => 'texte', 'libelle' => 'Rue']);
			$this->ajouterChamp(['nom' => 'complement_adresse_logements', 'requis' => false, 'type' => 'texte', 'libelle' => 'Complément d\'adresse']);
			$this->ajouterChamp(['nom' => 'ville_logements', 'type' => 'texte', 'libelle' => 'Ville']);
			$this->ajouterChamp(['nom' => 'cp_logements', 'type' => 'nombre', 'libelle' => 'Code postal']);
			$this->ajouterChamp(['nom' => 'prix_logements', 'type' => 'nombre', 'libelle' => 'Prix']);
			$this->ajouterChamp(['nom' => 'surface_logements', 'type' => 'nombre', 'libelle' => 'Surface']);
			$this->ajouterChamp(['nom' => 'photo', 'type' => 'fichier', 'extensions' => ['jpg', 'bmp', 'png'], 'libelle' => 'Photo']);
			$this->ajouterChamp(['nom' => 'description_photos', 'type' => 'texte', 'libelle' => 'Description de la photo']);
			$this->ajouterChamp(['nom' => 'type_logements', 'type' => 'nombre', 'libelle' => 'Type de logement']);
			$this->ajouterChamp(['nom' => 'nb_chambres_appartements', 'requis' => false, 'type' => 'nombre', 'libelle' => 'Nombre de chambres']);
			$this->ajouterChamp(['nom' => 'nb_places_appartements', 'requis' => false, 'type' => 'nombre', 'libelle' => 'Nombre de places']);
			$this->ajouterChamp(['nom' => 'parties_communes_chambres', 'requis' => false, 'type' => 'booleen', 'libelle' => 'Parties communes']);
			$this->ajouterChamp(['nom' => 'meuble_studios', 'requis' => false, 'type' => 'booleen', 'libelle' => 'Meublé']);
			$this->ajouterChamp(["nom" => 'libelle_motifs', 'type' => 'texte', 'libelle' => 'Raison pour laquelle vous proposez ce logement']);
			return $this->estValide();
		}
		
		public function modifier(){
			$this->ajouterChamp(['nom' => 'nom_proprietaire', 'type' => 'texte', 'libelle' => 'Nom']);
			$this->ajouterChamp(['nom' => 'prenom_proprietaire', 'type' => 'texte', 'libelle' => 'Prénom']);
			$this->ajouterChamp(['nom' => 'sexe_proprietaire', 'type' => 'texte', 'libelle' => 'Civilité']);
			$this->ajouterChamp(['nom' => 'rue_logements', 'type' => 'texte', 'libelle' => 'Rue']);
			$this->ajouterChamp(['nom' => 'complement_adresse_logements', 'requis' => false, 'type' => 'texte', 'libelle' => 'Complément d\'adresse']);
			$this->ajouterChamp(['nom' => 'ville_logements', 'type' => 'texte', 'libelle' => 'Ville']);
			$this->ajouterChamp(['nom' => 'cp_logements', 'type' => 'nombre', 'libelle' => 'Code postal']);
			$this->ajouterChamp(['nom' => 'prix_logements', 'type' => 'nombre', 'libelle' => 'Prix']);
			$this->ajouterChamp(['nom' => 'surface_logements', 'type' => 'nombre', 'libelle' => 'Surface']);
			$this->ajouterChamp(['nom' => 'photo', 'type' => 'fichier', 'requis' => false, 'extensions' => ['jpg', 'bmp', 'png'], 'libelle' => 'Photo']);
			$this->ajouterChamp(['nom' => 'description_photos', 'type' => 'texte', 'libelle' => 'Description de la photo']);
			$this->ajouterChamp(['nom' => 'type_logements', 'type' => 'nombre', 'libelle' => 'Type de logement']);
			$this->ajouterChamp(['nom' => 'nb_chambres_appartements', 'requis' => false, 'type' => 'nombre', 'libelle' => 'Nombre de chambres']);
			$this->ajouterChamp(['nom' => 'nb_places_appartements', 'requis' => false, 'type' => 'nombre', 'libelle' => 'Nombre de places']);
			$this->ajouterChamp(['nom' => 'parties_communes_chambres', 'requis' => false, 'type' => 'booleen', 'libelle' => 'Parties communes']);
			$this->ajouterChamp(['nom' => 'meuble_studios', 'requis' => false, 'type' => 'booleen', 'libelle' => 'Meublé']);
			$this->ajouterChamp(["nom" => 'libelle_motifs', 'type' => 'texte', 'libelle' => 'Raison pour laquelle vous proposez ce logement']);
			return $this->estValide();
		}
		
		public function voter()
		{
			$this->ajouterChamp(['nom' => 'vote', 'type' => 'nombre', 'requis' => false]);
			return $this->estValide();
		}
		
		public function chercher()
		{
			$this->ajouterChamp(['nom' => 'ville_logements', 'type' => 'nombre', 'libelle' => 'Ville']);
			return $this->estValide();
		}
	}
}