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
			$req = $this->BDD->prepare("SELECT * FROM logements l INNER JOIN personnes pe ON (l.id_proprietaires = pe.id_personnes) INNER JOIN photos ph ON (l.id_photos = ph.id_photos) INNER JOIN villes v ON (l.ville_logements = v.id_villes) WHERE ville_logements = ?");
			$req->execute([$idVille]);
			$logements = $req->fetchAll(\PDO::FETCH_OBJ);
			$req->closeCursor();
			return $logements;
		}
		
		public function recupTous()
		{
			$req = $this->BDD->query("SELECT * FROM logements l INNER JOIN personnes pe ON (l.id_proprietaires = pe.id_personnes) INNER JOIN photos ph ON (l.id_photos = ph.id_photos) INNER JOIN villes v ON (l.ville_logements = v.id_villes)");
			$logements = $req->fetchAll(\PDO::FETCH_OBJ);
			$req->closeCursor();
			return $logements;
		}
	}
}