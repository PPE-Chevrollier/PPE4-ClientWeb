<?php
namespace App\Controleurs
{
	class Profil extends \Systeme\Controleur
	{
		public function modifier()
		{
			$this->chargerService('connexion');
			$this->chargerModele('personnes');
			$personne = $this->serviceConnexion->recupPersonne();
			$this->chargerValidateur('personnes');
			if ($this->validateurPersonnes->modifier($personne->id_etudiants))
			{
				$this->personnes->modifierPersonne($this->session->recup('id_etudiants'), $this->validateurPersonnes->recupValeur('nom_etudiants'), $this->validateurPersonnes->recupValeur('prenom_etudiants'), $this->validateurPersonnes->recupValeur('email_etudiants'), $this->validateurPersonnes->recupValeur('tel_etudiants'), $this->validateurPersonnes->recupValeur('sexe_etudiants'));
				if (!empty($this->validateurPersonnes->recupValeur('mdp_etudiants')))
					$this->personnes->changerMotDePasse($personne->id_etudiants, $this->validateurPersonnes->recupValeur('mdp_etudiants'));
				$this->session->definir('message', 'Votre profil a bien été modifié !');
				$this->rediriger('profil', 'voir', [$personne->login_etudiants]);
			}
			else
			{
				$this->validateurPersonnes->definirValeur('nom_etudiants', $personne->nom_etudiants);
				$this->validateurPersonnes->definirValeur('prenom_etudiants', $personne->prenom_etudiants);
				$this->validateurPersonnes->definirValeur('email_etudiants', $personne->email_etudiants);
				$this->validateurPersonnes->definirValeur('tel_etudiants', $personne->tel_etudiants);
				$this->validateurPersonnes->definirValeur('sexe_etudiants', $personne->sexe_etudiants);
				$this->chargerVue('modifier', ['titre' => 'Modification du profil']);
			}
		}
		
		public function voir($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('personnes');
			$personne = $this->personnes->recupParNomUtilisateur($params[0]);
			if ($personne)
			{
				$this->chargerVue('', ['mail' => $personne->email_etudiants, 'nom' => $personne->nom_etudiants, 'nomUtilisateur' => $personne->login_etudiants, 'prenom' => $personne->prenom_etudiants, 'sexe' => $personne->sexe_etudiants, 'tel' => $personne->tel_etudiants, 'datenaiss' => $personne->datenaiss_etudiants, 'titre' => 'Profil de ' . $personne->login_etudiants]);
				$this->session->supprimer('message');
			}
			else
				$this->chargerVue('introuvable', ['nomUtilisateur' => $params[0], 'titre' => 'Utilisateur introuvable']);
		}
	}
}