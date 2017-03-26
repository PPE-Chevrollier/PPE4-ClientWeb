<?php
namespace App\Modeles
{
	class Proprietaires extends \Systeme\Modele
	{
		public function __construct($bdd)
		{
			parent::__construct($bdd);
		}
		
		public function ajouter($nom, $prenom, $sexe)
		{
			$req = $this->BDD->prepare("INSERT INTO personnes VALUES (NULL, ?, ?, ?)");
			$req->execute([$nom, $prenom, $sexe]);
			$req = $this->BDD->prepare("INSERT INTO proprietaires VALUES (?)");
			$idPersonne = $this->BDD->lastInsertId();
			$req->execute([$idPersonne]);
			return $idPersonne;
		}
		
		public function recup($nom, $prenom, $sexe)
		{
			$req = $this->BDD->prepare("SELECT * FROM vue_proprietaires WHERE nom_proprietaires = ? AND prenom_proprietaires = ? AND sexe_proprietaires = ?");
			$req->execute([$nom, $prenom, $sexe]);
			$proprietaire = $req->fetchObject();
			$req->closeCursor();
			return $proprietaire;
		}
                
		public function recherche($term){
			$req = $this->BDD->prepare("SELECT * FROM vue_proprietaires WHERE nom_proprietaires LIKE ? OR prenom_proprietaires LIKE ?");
			$req->execute([$term.'%', $term.'%']);
			$proprietaire = $req->fetchAll(\PDO::FETCH_OBJ);
			$req->closeCursor();
			return $proprietaire;
		}
	}
}