<?php
namespace Systeme
{
	class Html
	{
		private $champsRequis;
		private $controleur;
		private $validateur;
		
		public function __construct($controleur)
		{
			$this->controleur = $controleur;
		}
		
		public function boutonEnvoyer($nom = 'Envoyer')
		{
			echo '<input type="submit" value="' . $nom . '" /><br />';
		}
		
		public function boutonsRadio($nom, $elements)
		{
			echo '<p>' . $this->validateur->recupLibelle($nom);
			if ($this->validateur->estRequis($nom))
				echo '*';
			echo ' :</p>';
			foreach ($elements as $cle => $valeur)
			{
				echo '<input type="radio" id="' . $nom . '_' . $cle . '" name="' . $nom . '" value="' . $cle . '"';
				if ($this->validateur->recupValeur($nom) == $cle)
					echo ' checked';
				echo ' /><label class="libelleAligne" for="' . $nom . '_' . $cle . '">' . $valeur . '</label>';
			}
		}
		
		public function caseACocher($nom)
		{
			$check = ($this->validateur->recupValeur($nom)) ? "checked" : "";
			echo '<input type="checkbox" id="' . $nom . '" name="' . $nom . '" ' . $check . ' /><label class="libelleAligne" for="' . $nom . '">' . $this->validateur->recupLibelle($nom) . '</label>';
		}
		
		public function champ($nom)
		{
			$requis = $this->validateur->estRequis($nom);
			if ($requis && !$this->champsRequis)
				$this->champsRequis = true;
			$type = $this->validateur->recupType($nom);
			echo '<label for="' . $nom . '">' . $this->validateur->recupLibelle($nom);
			if ($requis)
				echo '*';
			echo ' :</label>';
			if ($type == 'texte' || $type == 'motdepasse' || $type == 'mail' || $type == 'nombre' || $type == 'telephone' || $type == 'fichier')
			{
				echo '<input type="';
				if ($type == 'texte')
					echo 'text';
				else if ($type == 'motdepasse')
					echo 'password';
				else if ($type == 'mail')
					echo 'email';
				else if ($type == 'nombre')
					echo 'number';
				else if ($type == 'telephone')
					echo 'tel';
				else if ($type == 'fichier')
					echo 'file';
				echo '" id="' . $nom . '" name="' . $nom . '" ';
				if ($type != 'motdepasse' && $type != 'fichier')
					echo 'value="' . $this->validateur->recupValeur($nom) . '" ';
				if ($requis)
					echo 'required ';
				echo '/>';
			}
			$erreur = $this->validateur->recupErreur($nom);
			if (!empty($erreur))
				echo '<div class="erreur">' . $erreur . '</div>';
		}
		
		public function champCache($nom)
		{
			echo '<input type="hidden" name="' . $nom . '" id="' . $nom . '" value="' . $this->validateur->recupValeur($nom) . '" ';
			if ($this->validateur->estRequis($nom))
				echo 'required ';
			echo '/>';
		}
		
		public function champMultiLigne($nom)
		{
			echo '<label for="' . $nom . '">' . $this->validateur->recupLibelle($nom);
			if ($this->validateur->estRequis($nom))
				echo '*';
			echo ' :</label><textarea name="' . $nom . '" id="' . $nom . '" rows="10" cols="50">' . $this->validateur->recupValeur($nom) . '</textarea>';
			$erreur = $this->validateur->recupErreur($nom);
			if ($erreur)
				echo '<div class="erreur">' . $erreur . '</div>';
		}
		
		public function fermerFormulaire()
		{
			if (!is_null($this->validateur))
			{
				$this->validateur = null;
				if ($this->champsRequis)
				{
					$this->champsRequis = false;
					echo 'Les champs marqués d\'un * sont obligatoires.';
				}
				echo '</form>';
			}
		}
		
		public function listeDeroulante($nom, $elements)
		{
			echo '<label for="' . $nom . '">' . $this->validateur->recupLibelle($nom);
			if ($this->validateur->estRequis($nom))
				echo '*';
			echo ' :</label>';
			echo '<select id="' . $nom . '" name="' . $nom . '">';
			foreach ($elements as $valeur => $texte)
			{
				echo '<option value="' . $valeur . '"';
				if ($this->validateur->recupValeur($nom) == $valeur)
					echo ' selected';
				echo '>' . $texte . '</option>';
			}
			echo '</select>';
		}
		
		public function ouvrirFormulaire($nom, $action = '#', $methode = 'post')
		{
			$nom = 'validateur' . ucfirst($nom);
			$this->validateur = $this->controleur->$nom;
			echo '<form action="' . $action . '" method="' . $methode . '"';
			if ($this->validateur->contientFichier())
				echo ' enctype="multipart/form-data"';
			echo '>';
		}
	}
}