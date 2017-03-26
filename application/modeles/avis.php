<?php
namespace App\Modeles
{
	class Avis extends \Systeme\Modele
	{
		public function __construct($bdd)
		{
			parent::__construct($bdd);
		}
		
		public function aVote($idEtudiant, $idLogement)
		{
			$req = $this->BDD->prepare("SELECT * FROM commentaires WHERE id_etudiants = ? AND id_logements = ?");
			$req->execute([$idEtudiant, $idLogement]);
			$vote = $req->fetchObject();
			$req->closeCursor();
			return $vote != null;
		}
		
		public function voter($idEtudiant, $idLogement, $note)
		{
			$req = $this->BDD->prepare("INSERT INTO commentaires VALUES (?, ?, CURDATE(), ?)");
			$req->execute([$idLogement, $idEtudiant, $note]);
		}
	}
}