<?php
namespace App\Validateurs
{
	class Personnes extends \Systeme\Validateur
	{
		public function __construct($controleur, $modele)
		{
			parent::__construct($controleur, $modele);
			$this->ajouterChamp(['nom' => 'email_etudiants', 'type' => 'mail', 'libelle' => 'E-mail']);
		}
		
		public function connecter()
		{
			$this->ajouterChamp(['nom' => 'mdp_etudiants', 'type' => 'motdepasse', 'libelle' => 'Mot de passe']);
			if ($this->estValide())
			{
				$personne = $this->modele->recupParMail($this->recupValeur('email_etudiants'));
				if (!$personne)
					$this->definirErreur('email_etudiants', 'Cet email n\'existe pas.');
				else if ($personne->mdp_etudiants != $this->recupValeur('mdp_etudiants'))
					$this->definirErreur('mdp_etudiants', 'Le mot de passe est incorrect.');
				else
				{
					$this->definirValeur('id_etudiants', $personne->id_etudiants);
					$this->definirValeur('prenom_etudiants', $personne->prenom_etudiants);
          $this->definirValeur('login_etudiants', $personne->login_etudiants);
					return true;
				}
			}
		}
		
		public function modifier($id)
		{
			$this->ajouterChamp(['nom' => 'nom_etudiants', 'type' => 'texte', 'libelle' => 'Nom']);
			$this->ajouterChamp(['nom' => 'prenom_etudiants', 'type' => 'texte', 'libelle' => 'Prénom']);
			$this->ajouterChamp(['nom' => 'tel_etudiants', 'requis' => false, 'type' => 'telephone', 'libelle' => 'N° de téléphone']);
			$this->ajouterChamp(['nom' => 'sexe_etudiants', 'type' => 'texte', 'libelle' => 'Sexe']);
			$this->ajouterChamp(['nom' => 'mdp_actuel', 'requis' => false, 'type' => 'motdepasse', 'libelle' => 'Mot de passe actuel']);
			$this->ajouterChamp(['nom' => 'mdp_etudiants', 'requis' => false, 'type' => 'motdepasse', 'libelle' => 'Nouveau mot de passe']);
			$this->ajouterChamp(['nom' => 'confirmation_mdp', 'requis' => false, 'type' => 'motdepasse', 'libelle' => 'Confirmer le mot de passe']);
			if ($this->estValide())
			{
				if (!empty($this->recupValeur('mdp_etudiants')))
				{
					echo '-------> ' . $this->recupValeur('mdp_etudiants');
					$personne = $this->modele->recupParID($id);
					if ($this->recupValeur('mdp_actuel') != $personne->mdp_etudiants)
						$this->definirErreur('mdp_actuel', 'Veuillez insérer votre mot de passe actuel.');
					else if ($this->recupValeur('mdp_etudiants') != $this->recupValeur('confirmation_mdp'))
						$this->definirErreur('confirmation_mdp', 'La confirmation du mot de passe est incorrecte.');
					else
						return true;
					return false;
				}
				return true;
			}
			return false;
		}
	}
}