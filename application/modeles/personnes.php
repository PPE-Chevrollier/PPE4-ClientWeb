<?php
namespace App\Modeles
{
	class Personnes extends \Systeme\Modele
	{
		public function __construct($bdd)
		{
			parent::__construct($bdd);
		}
		
		public function modifierPersonne($id, $nom, $prenom, $mail, $tel, $sexe)
		{
			$req = $this->BDD->prepare('UPDATE personnes SET nom_personnes = ?, prenom_personnes = ?, email_personnes = ?, tel_personnes = ? WHERE id_personnes = ?');
			$req->execute([$nom, $prenom, $mail, $sexe, $tel, $id]);
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
    					
		  $tabResult = array();
    
		  $req = $this->BDD->prepare('SELECT login(:user, :mdp) AS \'result\'');
		  $req->bindParam(':user', $user, \PDO::PARAM_STR);
		  $req->bindParam(':mdp', $mdp, \PDO::PARAM_STR);
		  $req->execute();
    
      $tabResult["result"] = $req->fetchObject()->result;
    
		  if ($tabResult["result"] == "1"){
		      $personne = $this->recupParNomUtilisateur($user);
		      
		      $tabResult["name"] = $personne->nom_personnes;
		      $tabResult["prenom"] = $personne->prenom_personnes;
		  }
		  
		  $req->closeCursor();
		  
		  return json_encode($tabResult);
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
