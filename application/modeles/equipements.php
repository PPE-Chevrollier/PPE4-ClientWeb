<?php
namespace App\Modeles
{
	class Equipements extends \Systeme\Modele
	{
		public function __construct($bdd)
		{
			parent::__construct($bdd);
		}
		
		public function recherche($terme)
		{
			$req = $this->BDD->prepare("SELECT * FROM equipements WHERE libelle_equipements LIKE ?");
			$req->execute([$terme . '%']);
			$equipements = $req->fetchAll(\PDO::FETCH_OBJ);
			$req->closeCursor();
			return $equipements;
		}
                
		public function recup($nom)
		{
			$req = $this->BDD->prepare("SELECT * FROM equipements WHERE libelle_equipements = ?");
			$req->execute([$nom]);
			$equipement = $req->fetchObject();
			$req->closeCursor();
			return $equipement;
		}
		
		public function recupParLogement($idLogement)
		{
			$req = $this->BDD->prepare("SELECT * FROM composent c INNER JOIN equipements e ON (c.id_equipements = e.id_equipements) WHERE id_logements = ? ORDER BY libelle_equipements");
			$req->execute([$idLogement]);
			$equipements = $req->fetchAll(\PDO::FETCH_OBJ);
			$req->closeCursor();
			return $equipements;
		}
		
		public function ajouter($nom)
		{
			$req = $this->BDD->prepare("INSERT INTO equipements VALUES (NULL, ?)");
			$req->execute([$nom]);
			return $this->BDD->lastInsertId();
		}
	}
}