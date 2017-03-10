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
            $this->chargerModele('personnes');
            echo $this->personnes->apiCconnexion($tab[0], sha1($tab[1]));
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
            $email = $this->personnes->recupParNomUtilisateur($tab[0]);
            
            echo $mdp.'<br />';
            echo md5($mdp).'<br />';
            echo $email->email_personnes;
            
        }
    }
}