<?php
namespace App\Modeles
{
	class Motifs extends \Systeme\Modele
	{
		public function __construct($bdd)
		{
			parent::__construct($bdd);
		}
		
		public function recherche($terme)
		{
			$req = $this->BDD->prepare("SELECT * FROM motifs WHERE libelle_motifs LIKE ?");
                        $req->execute([$terme . '%']);
			$motifs = $req->fetchAll(\PDO::FETCH_OBJ);
			$req->closeCursor();
			return $motifs;
		}
                
		public function recup($nom)
		{
			$req = $this->BDD->prepare("SELECT * FROM motifs WHERE libelle_motifs = ?");
			$req->execute([$nom]);
			$motif = $req->fetchObject();
			$req->closeCursor();
			return $motif;
		}
                
		public function ajouter($nom)
		{
			$req = $this->BDD->prepare("INSERT INTO motifs VALUES (null, ?)");
			$req->execute([$nom]);
			return $this->BDD->lastInsertId();
		}
	}
}