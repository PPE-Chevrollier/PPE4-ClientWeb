<?php
namespace App\Controleurs
{
    class api extends \Systeme\Controleur
    {
        public function recupUtilisateurs(){
            $this->chargerModele('personnes');
            echo $this->personnes->apiRecupUtilisateurs();
        }
        
        public function connexion($tab){
            if (!isset($tab[0])) return;
            $tabResult = array();
            $this->chargerModele('personnes');
            $etat = $this->personnes->apiCconnexion($tab[0], sha1($tab[1]));
            $tabResult["etat"] = $etat;     
            if ($etat == "1"){
      		      $personne = $this->personnes->recupParNomUtilisateur($tab[0]);
      		      $tabResult["nom"] = $personne->nom_etudiants;
      		      $tabResult["prenom"] = $personne->prenom_etudiants;
      		  }
      		  echo json_encode($tabResult);
        }
        
        public function changerMotDePasse($tab){        
            if (!isset($tab[0])) return;
            $result = array();
            $this->chargerModele('personnes');
            $characters = '023456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ#!$';
            $specials = '#!?$%&*';         
            $firstPart = substr(str_shuffle($characters), 0, 7);
            $lastPart = substr(str_shuffle($specials), 0, 1);            
            $mdp = str_shuffle($firstPart . $lastPart);            
            $etat = $this->personnes->apiResetPassword($tab[0], sha1($mdp));
            $user = $this->personnes->recupParNomUtilisateur($tab[0]);
            $subject = 'Mot de passe r�initialis�';
            $message = 'Voici votre nouveau mot de passe ChevLoc : '.$mdp;
            $headers = 'From: ChevLoc@chevrollier.fr';
            $etat *= mail($user->email_etudiants, $subject, $message, $headers);
            $result["etat"] = $etat;
            echo json_encode($result);
        }
    }
}