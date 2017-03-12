<?php
namespace App\Modeles
{
	class Personnes extends \Systeme\Modele
	{
		public function __construct($bdd)
		{
			parent::__construct($bdd);
		}
		
		public function changerMotDePasse($id, $mdp)
		{
			$req = $this->BDD->prepare("UPDATE personnes SET mdp_etudiants = ? WHERE id_personnes = ?");
			$req->execute([$mdp, $id]);
		}
		
		public function modifierPersonne($id, $nom, $prenom, $mail, $tel, $sexe)
		{
			$req = $this->BDD->prepare('UPDATE personnes SET nom_personnes = ?, prenom_personnes = ?, email_personnes = ?, tel_personnes = ?, sexe_personnes = ? WHERE id_personnes = ?');
			$req->execute([$nom, $prenom, $mail, $tel, $sexe, $id]);
		}
		
		public function recupParNomUtilisateur($nomUtilisateur)
		{
			$req = $this->BDD->prepare('SELECT * FROM personnes WHERE login_etudiants = ?');
			$req->execute([$nomUtilisateur]);
			$personne = $req->fetchObject();
			$req->closeCursor();
			return $personne;
		}
   
   	public function recupParID($ID)
		{
			$req = $this->BDD->prepare('SELECT * FROM personnes WHERE id_personnes = ?');
			$req->execute([$ID]);
			$personne = $req->fetchObject();
			$req->closeCursor();
			return $personne;
		}
		
		public function recupPersonneParMail($mail)
		{
			$req = $this->BDD->prepare('SELECT * FROM personnes WHERE email_personnes = ?');
			$req->execute([$mail]);
			$personne = $req->fetchObject();
			$req->closeCursor();
			return $personne;
		}
                    
    public function apiCconnexion($user, $mdp){		
		  $req = $this->BDD->prepare('SELECT login(?, ?) AS \'result\'');
      $req->execute([$user, $mdp]);
		  $result = $req->fetchObject();
      $req->closeCursor();
      return $result->result;
    }
    
    public function apiRecupUtilisateurs(){
      $req = $this->BDD->query('SELECT * FROM personnes WHERE login_etudiants IS NOT NULL');
      $users = $req->fetchAll(\PDO::FETCH_ASSOC);
      return json_encode($users);
    }
    
    public function apiResetPassword($nomUtilisateur, $newMdp){
      $req = $this->BDD->prepare('UPDATE personnes SET MDP_ETUDIANTS = ? WHERE login_etudiants = ?');
      $req->execute([$newMdp, $nomUtilisateur]);
    }
	}
}
