<?php
namespace App\Modeles
{
	class Villes extends \Systeme\Modele
	{
		public function __construct($bdd)
		{
			parent::__construct($bdd);
		}
		
		public function ajouter($nom)
		{
			$req = $this->BDD->prepare("INSERT INTO villes VALUES (NULL, ?)");
			$req->execute([$nom]);
			return $this->BDD->lastInsertId();
		}
		
		public function recup($nom)
		{
			$req = $this->BDD->prepare("SELECT * FROM villes WHERE nom_villes = ?");
			$req->execute([$nom]);
			$ville = $req->fetchObject();
			$req->closeCursor();
			return $ville;
		}
		
		public function recupParId($id)
		{
			$req = $this->BDD->prepare("SELECT * FROM villes WHERE id_villes = ?");
			$req->execute([$id]);
			$ville = $req->fetchObject();
			$req->closeCursor();
			return $ville;
		}
		
		public function recupToutes()
		{
			$req = $this->BDD->query("SELECT * FROM villes v JOIN logements l ON v.id_villes = l.ville_logements ORDER BY nom_villes");
			$villes = $req->fetchAll(\PDO::FETCH_OBJ);
			$req->closeCursor();
			return $villes;
		}
		
		public function recherche($terme)
		{
			$req = $this->BDD->prepare("SELECT * FROM villes WHERE nom_villes LIKE ?");
			$req->execute([$terme . '%']);
			$villes = $req->fetchAll(\PDO::FETCH_OBJ);
			$req->closeCursor();
			return $villes;
		}
	}
}