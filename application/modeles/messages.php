<?php
namespace App\Modeles
{
	class Messages extends \Systeme\Modele
	{
		public function __construct($bdd)
		{
			parent::__construct($bdd);
		}
		
		public function ecrire($idAuteur, $idDestinataire, $sujet, $texte)
		{
			$req = $this->BDD->prepare("INSERT INTO messages VALUES (NULL, ?, ?, CURDATE(), ?, 0, ?)");
			$req->execute([$idAuteur, $idDestinataire, $texte, $sujet]);
			return $this->BDD->lastInsertId();
		}
		
		public function lire($id)
		{
			$req = $this->BDD->prepare("UPDATE messages SET lu_messages = 1 WHERE id_messages = ?");
			$req->execute([$id]);
		}
		
		public function nbNonLus($idEtudiant)
		{
			$req = $this->BDD->prepare("SELECT COUNT(*) nb, lu_messages FROM messages GROUP BY destinataire_messages HAVING destinataire_messages = ? AND lu_messages = 0");
			$req->execute([$idEtudiant]);
			$nb = $req->fetchObject();
			$req->closeCursor();
			return $nb;
		}
		
		public function recupParEtudiant($idEtudiant)
		{
			$req = $this->BDD->prepare("SELECT m.id_messages, p.nom_personnes, p.prenom_personnes, p.sexe_personnes, m.date_messages, m.sujet_messages, m.texte_messages, m.lu_messages FROM messages m INNER JOIN personnes p ON (m.auteur_messages = p.id_personnes) WHERE destinataire_messages = ?");
			$req->execute([$idEtudiant]);
			$messages = $req->fetchAll(\PDO::FETCH_OBJ);
			$req->closeCursor();
			return $messages;
		}
		
		public function recupParId($id)
		{
			$req = $this->BDD->prepare("SELECT m.id_messages, m.auteur_messages, m.destinataire_messages, p.nom_personnes, p.prenom_personnes, p.sexe_personnes, m.date_messages, m.sujet_messages, m.texte_messages FROM messages m INNER JOIN personnes p ON (m.auteur_messages = p.id_personnes) WHERE m.id_messages = ?");
			$req->execute([$id]);
			$message = $req->fetchObject();
			$req->closeCursor();
			return $message;
		}
		
		public function supprimer($id)
		{
			$req = $this->BDD->prepare("DELETE FROM messages WHERE id_messages = ?");
			$req->execute([$id]);
		}
	}
}