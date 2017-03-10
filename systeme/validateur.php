<?php
namespace Systeme
{
	class Validateur
	{
		private $champs;
		protected $controleur;
		protected $modele;
		
		public function __construct($controleur, $modele)
		{
			$this->champs = [];
			$this->controleur = $controleur;
			$this->modele = $modele;
		}
		
		public function ajouter()
		{
			return $this->estValide();
		}
		
		protected function ajouterChamp($champ)
		{
			if (!isset($champ['type']))
				$champ['type'] = 'texte';
			if (!isset($champ['libelle']))
				$champ['libelle'] = ucfirst($champ['nom']);
			if (!isset($champ['requis']))
				$champ['requis'] = true;
			$this->champs[$champ['nom']] = $champ;
		}
		
		public function definirErreur($nom, $message)
		{
			$this->champs[$nom]['erreur'] = $message;
		}
		
		public function definirValeur($nom, $valeur)
		{
			$this->champs[$nom]['valeur'] = $valeur;
		}
		
		public function estRequis($nom)
		{
			return !isset($this->champs[$nom]['requis']) || $this->champs[$nom]['requis'];
		}
		
		protected function estValide()
		{
			foreach ($this->champs as $nom => $valeur)
			{
				if (!isset($_POST[$nom]))
					return false;
			}
			$erreur = false;
			foreach ($this->champs as $nom => $valeur)
			{
				if ($this->estRequis($nom) && empty($_POST[$nom]))
				{
					$this->champs[$nom]['erreur'] = 'Le champ « ' . $this->recupLibelle($nom) . ' » est requis.';
					$erreur = true;
				}
				else
				{
					if ($this->recupType($nom) == 'motdepasse')
						$this->definirValeur($nom, sha1($_POST[$nom]));
					else
						$this->definirValeur($nom, $_POST[$nom]);
				}
			}
			return !$erreur;
		}
		
		public function recupErreur($nom)
		{
			if (!isset($this->champs[$nom]['erreur']))
				return false;
			return $this->champs[$nom]['erreur'];
		}
		
		public function recupLibelle($nom)
		{
			if (!isset($this->champs[$nom]['libelle']))
				return ucfirst($nom);
			return $this->champs[$nom]['libelle'];
		}
		
		public function recupType($nom)
		{
			if (!isset($this->champs[$nom]['type']))
				return 'texte';
			return $this->champs[$nom]['type'];
		}
		
		public function recupValeur($nom)
		{
			if (!isset($this->champs[$nom]['valeur']))
				return false;
			return $this->champs[$nom]['valeur'];
		}
	}
}