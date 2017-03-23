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
		
		public function contientFichier()
		{
			foreach ($this->champs as $nom => $champ)
			{
				if ($this->recupType($nom) == 'fichier')
					return true;
			}
			return false;
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
				if ($this->recupType($nom) == 'fichier')
				{
					if (!isset($_FILES[$nom]))
						return false;
				}
				else if ($this->recupType($nom) == 'booleen')
					continue;
				else if (!isset($_POST[$nom]))
					return false;
			}
			$erreur = false;
			foreach ($this->champs as $nom => $valeur)
			{                         
                                if ($this->estRequis($nom)){
                                    
                                    if ($this->recupType($nom) == 'fichier' && empty($_FILES[$nom])){
                                        $this->definirErreur($nom, 'Le champ « ' . $this->recupLibelle($nom) . ' » est requis.');
					$erreur = true;
                                        continue;
                                    }
                                    else if ($this->recupType($nom) == 'booleen' && $_POST[$nom] != 'on'){
                                        $this->definirErreur($nom, 'Veuillez cocher la case.');
                                        $erreur = true;
                                        continue;
                                    }
                                    
                                }
                                if ($this->recupType($nom) == 'motdepasse' && !empty($_POST[$nom]))
                                        $this->definirValeur($nom, sha1($_POST[$nom]));
                                else if ($this->recupType($nom) == 'fichier')
                                {
                                        $typeFichier = pathinfo($_FILES[$nom]['name'], \PATHINFO_EXTENSION);
                                        if (!in_array($typeFichier, $valeur['extensions']))
                                        {
                                                $listeExtensions = '';
                                                foreach ($valeur['extensions'] as $e)
                                                {
                                                        if ($listeExtensions != '')
                                                                $listeExtensions .= '/';
                                                        $listeExtensions .= $e;
                                                }
                                                $this->definirErreur($nom, 'Le fichier doit être de type ' . $listeExtensions . '.');
                                                $erreur = true;
                                        }
                                        else
                                                $this->definirValeur($nom, $_FILES[$nom]);
                                }
                                else if ($this->recupType($nom) == 'booleen')
                                {
                                  if (isset($_POST[$nom]) && $_POST[$nom] == 'on'){
                                    $this->definirValeur($nom, true);
                                  }
                                  else $this->definirValeur($nom, false);
                                }
                                else
                                        $this->definirValeur($nom, $_POST[$nom]);
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