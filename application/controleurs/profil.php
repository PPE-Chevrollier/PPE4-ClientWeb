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
			if ($this->validateurPersonnes->modifier($personne->id_personnes))
			{
				$this->personnes->modifierPersonne($this->session->recup('id_personnes'), $this->validateurPersonnes->recupValeur('nom_personnes'), $this->validateurPersonnes->recupValeur('prenom_personnes'), $this->validateurPersonnes->recupValeur('email_personnes'), $this->validateurPersonnes->recupValeur('tel_personnes'), $this->validateurPersonnes->recupValeur('sexe_personnes'));
				if (!empty($this->validateurPersonnes->recupValeur('mdp_etudiants')))
					$this->personnes->changerMotDePasse($personne->id_personnes, $this->validateurPersonnes->recupValeur('mdp_etudiants'));
				$this->session->definir('message', 'Votre profil a bien été modifié !');
				$this->rediriger('profil', 'voir', [$personne->login_etudiants]);
			}
			else
			{
				$this->validateurPersonnes->definirValeur('nom_personnes', $personne->nom_personnes);
				$this->validateurPersonnes->definirValeur('prenom_personnes', $personne->prenom_personnes);
				$this->validateurPersonnes->definirValeur('email_personnes', $personne->email_personnes);
				$this->validateurPersonnes->definirValeur('tel_personnes', $personne->tel_personnes);
				$this->validateurPersonnes->definirValeur('sexe_personnes', $personne->sexe_personnes);
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
				$this->chargerVue('', ['mail' => $personne->email_personnes, 'nom' => $personne->nom_personnes, 'nomUtilisateur' => $personne->login_etudiants, 'prenom' => $personne->prenom_personnes, 'sexe' => $personne->sexe_personnes, 'tel' => $personne->tel_personnes, 'titre' => 'Profil de ' . $personne->login_etudiants]);
				$this->session->supprimer('message');
			}
			else
				$this->chargerVue('introuvable', ['nomUtilisateur' => $params[0], 'titre' => 'Utilisateur introuvable']);
		}
	}
}