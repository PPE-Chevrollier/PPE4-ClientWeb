<?php

namespace App\Modeles {

    class Personnes extends \Systeme\Modele {

        public function __construct($bdd) {
            parent::__construct($bdd);
        }

        public function changerMotDePasse($id, $mdp) {
            $req = $this->BDD->prepare("UPDATE etudiants SET mdp_etudiants = ? WHERE id_etudiants = ?");
            $req->execute([$mdp, $id]);
        }

        public function modifierPersonne($id, $nom, $prenom, $mail, $tel, $sexe) {
            $reqPersonnes = $this->BDD->prepare('UPDATE personnes SET nom_personnes = ?, prenom_personnes = ?, sexe_personnes = ? WHERE id_personnes = ?');
            $reqEtudiants = $this->BDD->prepare('UPDATE etudiants SET email_etudiants = ?, tel_etudiants = ? WHERE id_etudiants = ?');
            $reqPersonnes->execute([$nom, $prenom, $sexe, $id]);
            $reqEtudiants->execute([$mail, $tel, $id]);
        }

        public function recupParNomUtilisateur($nomUtilisateur) {
            $req = $this->BDD->prepare('SELECT * FROM vue_etudiants WHERE login_etudiants = ?');
            $req->execute([$nomUtilisateur]);
            $personne = $req->fetchObject();
            $req->closeCursor();
            return $personne;
        }

        public function recupParID($ID) {
            $req = $this->BDD->prepare('SELECT * FROM vue_etudiants WHERE id_etudiants = ?');
            $req->execute([$ID]);
            $personne = $req->fetchObject();
            $req->closeCursor();
            return $personne;
        }

        public function recupParMail($mail) {
            $req = $this->BDD->prepare('SELECT * FROM vue_etudiants WHERE email_etudiants = ?');
            $req->execute([$mail]);
            $personne = $req->fetchObject();
            $req->closeCursor();
            return $personne;
        }

        public function apiCconnexion($user, $mdp) {
            $req = $this->BDD->prepare('SELECT login(?, ?) AS \'result\'');
            $req->execute([$user, $mdp]);
            $result = $req->fetchObject();
            $req->closeCursor();
            return $result->result;
        }

        public function apiRecupUtilisateurs() {
            $req = $this->BDD->query('SELECT * FROM vue_etudiants');
            $users = $req->fetchAll(\PDO::FETCH_ASSOC);
            return json_encode($users);
        }

        public function apiResetPassword($nomUtilisateur, $newMdp) {
            $req = $this->BDD->prepare('UPDATE etudiants SET mdp_etudiants = ? WHERE login_etudiants = ?');
            return $req->execute([$newMdp, $nomUtilisateur]);
        }

    }

}
