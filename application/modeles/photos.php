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
		
		public function recupPhotosParLogement($idLogement)
		{
			$req = $this->BDD->prepare("SELECT * FROM illustrer i INNER JOIN photos p ON (i.id_photos = p.id_photos) WHERE i.id_logements = ?");
			$req->execute([$idLogement]);
			$photos = $req->fetchAll(PDO::FETCH_OBJ);
			$req->closeCursor();
			return $photos;
		}
	}
}