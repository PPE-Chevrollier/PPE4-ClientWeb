<?php
namespace App\Modeles
{
	class Photos extends \Systeme\Modele
	{
		public function __construct($bdd)
		{
			parent::__construct($bdd);
		}
		
		public function ajouter($extension, $description)
		{
			$req = $this->BDD->prepare("INSERT INTO photos VALUES (NULL, ?, ?)");
			$req->execute([$extension, $description]);
			return $this->BDD->lastInsertId();
		}
		
		public function droitSurPhoto($idPhoto, $idEtudiant)
		{
			$req = $this->BDD->prepare("SELECT i.id_photos id_photos, l.id_logements id_logements, l.id_photos photo_logements, p.id_etudiants id_etudiants FROM illustrer i INNER JOIN logements l ON (i.id_logements = l.id_logements) INNER JOIN propositions p ON (l.id_logements = p.id_logements) WHERE i.id_photos = ? AND p.id_etudiants = ?");
			$req->execute([$idPhoto, $idEtudiant]);
			$droit = $req->fetchObject();
			$req->closeCursor();
			return $droit;
		}
		
		public function modifier($id, $description)
		{
			$req = $this->BDD->prepare("UPDATE photos SET description_photos = ? WHERE id_photos = ?");
			$req->execute([$description, $id]);
		}
		
		public function recupParId($id)
		{
			$req = $this->BDD->prepare("SELECT * FROM photos WHERE id_photos = ?");
			$req->execute([$id]);
			$photo = $req->fetchObject();
			$req->closeCursor();
			return $photo;
		}
		
		public function recupParLogement($idLogement)
		{
			$req = $this->BDD->prepare("SELECT * FROM illustrer i INNER JOIN photos p ON (i.id_photos = p.id_photos) WHERE i.id_logements = ?");
			$req->execute([$idLogement]);
			$photos = $req->fetchAll(\PDO::FETCH_OBJ);
			$req->closeCursor();
			return $photos;
		}
		
		public function supprimer($id)
		{
			$req = $this->BDD->prepare("DELETE FROM illustrer WHERE id_photos = ?");
			$req->execute([$id]);
			$req = $this->BDD->prepare("DELETE FROM photos WHERE id_photos = ?");
			$req->execute([$id]);
		}
	}
}