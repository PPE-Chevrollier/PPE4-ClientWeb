<?php
namespace App\Validateurs
{
	class Personnes extends \Systeme\Validateur
	{
		public function __construct($controleur, $modele)
		{
			parent::__construct($controleur, $modele);
			$this->ajouterChamp(['nom' => 'email_personnes', 'type' => 'mail', 'libelle' => 'E-mail']);
		}
		
		public function connecter()
		{
			$this->ajouterChamp(['nom' => 'mdp_etudiants', 'type' => 'motdepasse', 'libelle' => 'Mot de passe']);
			if ($this->estValide())
			{
				$personne = $this->modele->recupPersonneParMail($this->recupValeur('email_personnes'));
				if (!$personne)
					$this->definirErreur('email_personnes', 'Cet email n\'existe pas.');
				else if ($personne->mdp_etudiants != $this->recupValeur('mdp_etudiants'))
					$this->definirErreur('mdp_etudiants', 'Le mot de passe est incorrect.');
				else
				{
					$this->definirValeur('id_personnes', $personne->id_personnes);
					$this->definirValeur('prenom_personnes', $personne->prenom_personnes);
					return true;
				}
			}
		}
		
		public function modifier()
		{
			$this->ajouterChamp(['nom' => 'nom_personnes', 'type' => 'texte', 'libelle' => 'Nom']);
			$this->ajouterChamp(['nom' => 'prenom_personnes', 'type' => 'texte', 'libelle' => 'Prénom']);
			$this->ajouterChamp(['nom' => 'tel_personnes', 'requis' => false, 'type' => 'telephone', 'libelle' => 'N° de téléphone']);
			$this->ajouterChamp(['nom' => 'ancien_mdp', 'requis' => false, 'type' => 'motdepasse', 'libelle' => 'Ancien mot de passe']);
			$this->ajouterChamp(['nom' => 'mdp_etudiants', 'requis' => false, 'type' => 'motdepasse', 'libelle' => 'Mot de passe']);
			$this->ajouterChamp(['nom' => 'confirmation_mdp', 'requis' => false, 'type' => 'motdepasse', 'libelle' => 'Confirmer le mot de passe']);
			return $this->estValide();
		}
	}
}