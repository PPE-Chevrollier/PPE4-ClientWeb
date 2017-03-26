<?php
namespace App\Modeles
{
	class Logements extends \Systeme\Modele
	{
		public function __construct($bdd)
		{
			parent::__construct($bdd);
		}
		
		public function ajouter($idProprietaire, $idPhoto, $rue, $complementAdresse, $idVille, $cp, $prix, $surface)
		{
			$req = $this->BDD->prepare("INSERT INTO logements VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)");
			$req->execute([$idPhoto, $idProprietaire, $rue, $idVille, $cp, $complementAdresse, $prix, $surface]);
			return $this->BDD->lastInsertId();
		}
		
		public function ajouterEquipement($idLogement, $idEquipement)
		{
			$req = $this->BDD->prepare("INSERT INTO composent VALUES (?, ?)");
			$req->execute([$idEquipement, $idLogement]);
			return $this->BDD->lastInsertId();
		}
		
		public function changerPhoto($idLogement, $idPhoto)
		{
			$req = $this->BDD->prepare("UPDATE logements SET id_photos = ? WHERE id_logements = ?");
			$req->execute([$idPhoto, $idLogement]);
		}
		
		public function modifier($idLogement, $idProprietaire, $idPhoto, $rue, $complementAdresse, $idVille, $cp, $prix, $surface){
			$req = $this->BDD->prepare("UPDATE logements SET id_photos = ?, id_proprietaires = ?, rue_logements = ?, ville_logements = ?, cp_logements = ?, complement_adresse_logements = ?, prix_logements = ?, surface_logements = ? WHERE id_logements = ?");
			$req->execute([$idPhoto, $idProprietaire, $rue, $idVille, $cp, $complementAdresse, $prix, $surface, $idLogement]);
		}
		
		public function modifierProposition($idLogement, $date, $idEtudiant, $idMotif){
			$req = $this->BDD->prepare("UPDATE propositions SET id_motifs = ? WHERE id_logements = ? AND date = ? AND id_etudiants = ?");
			$req->execute([$idMotif, $idLogement, $date, $idEtudiant]);
		}
		
		public function ajouterIllustration($idLogement, $idPhoto)
		{
			$req = $this->BDD->prepare("INSERT INTO illustrer VALUES (?, ?)");
			$req->execute([$idPhoto, $idLogement]);
		}
		
		public function ajouterProposition($idLogement, $idEtudiant, $idMotif)
		{
			$req = $this->BDD->prepare("INSERT INTO propositions VALUES (?, CURDATE(), ?, ?)");
			$req->execute([$idLogement, $idEtudiant, $idMotif]);
		}
   
		public function ajouterAppartement($idAppartement, $nbPlaces, $nbChambres){
			$req = $this->BDD->prepare("INSERT INTO appartements VALUES (?, ?, ?)");
			$req->execute([$idAppartement, $nbPlaces, $nbChambres]);   
		}
   
		public function ajouterChambreHabitant($idChambre, $pc){
			$req = $this->BDD->prepare("INSERT INTO chambresHabitant VALUES (?, ?)");
			$req->execute([$idChambre, $pc]);   
		}
   
		public function ajouterStudio($idStudio, $meubleStudios){
			$req = $this->BDD->prepare("INSERT INTO studios VALUES (?, ?)");
			$req->execute([$idStudio, $meubleStudios]);
		}
		
		public function droitSurLogement($idLogement, $idEtudiant){
			$req = $this->BDD->prepare("SELECT * FROM propositions WHERE id_logements = ? AND id_etudiants = ?");
			$req->execute([$idLogement, $idEtudiant]);
			$droit = $req->fetchObject();
			$req->closeCursor();			
			return $droit != null;
		}
		
		public function noter($idLogement, $idEtudiant, $note)
		{
			$req = $this->BDD->prepare("INSERT INTO commentaires VALUES (?, CURDATE(), ?, ?)");
			$req->execute([$idLogement, $idEtudiant, $note]);
		}
		
		public function recupParId($id)
		{
			$req = $this->BDD->prepare("SELECT * FROM vue_logements WHERE id_logements = ?");
			$req->execute([$id]);
			$logement = $req->fetchObject();
			$req->closeCursor();
			return $logement;
		}
		
		public function recupParVille($idVille)
		{
			$req = $this->BDD->prepare("SELECT * FROM vue_logements WHERE ville_logements = ?");
			$req->execute([$idVille]);
			$logements = $req->fetchAll(\PDO::FETCH_OBJ);
			$req->closeCursor();
			return $logements;
		}
		
		public function recupTous()
		{
			$req = $this->BDD->query("SELECT * FROM vue_logements");
			$logements = $req->fetchAll(\PDO::FETCH_OBJ);
			$req->closeCursor();
			return $logements;
		}
		
		public function supprimerEquipement($idLogement, $idEquipement)
		{
			$req = $this->BDD->prepare("DELETE FROM composent WHERE id_logements = ? AND id_equipements = ?");
			$req->execute([$idLogement, $idEquipement]);
		}
		
		public function supprimerSousTypes($idLogements){
			$req1 = $this->BDD->prepare("CALL supprimerSousTypes(?)");
			$req1->execute([$idLogements]);
		}
	}
}