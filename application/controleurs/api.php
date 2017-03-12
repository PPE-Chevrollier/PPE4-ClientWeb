<?php
namespace App\Controleurs
{
    class api extends \Systeme\Controleur
    {
        public function getUsers(){
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
      		      $tabResult["nom"] = $personne->nom_personnes;
      		      $tabResult["prenom"] = $personne->prenom_personnes;
      		  }
      		  echo json_encode($tabResult);
        }
        
        public function resetMdp($tab){        
            if (!isset($tab[0])) return;        
            $this->chargerModele('personnes');
            $characters = '023456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ#!$';
            $specials = '#!?$%&*';         
            $firstPart = substr(str_shuffle($characters), 0, 7);
            $lastPart = substr(str_shuffle($specials), 0, 1);            
            $mdp = str_shuffle($firstPart . $lastPart);            
            $this->personnes->apiResetPassword($tab[0], sha1($mdp));
            $user = $this->personnes->recupParNomUtilisateur($tab[0]);
            $subject = 'Mot de passe réinitialisé';
            $message = 'Voici votre nouveau mot de passe ChevLoc : '.$mdp;
            $headers = 'From: noreply@chevrollier.fr';        
            mail($user->email_personnes, $subject, $message, $headers);          
        }
    }
}