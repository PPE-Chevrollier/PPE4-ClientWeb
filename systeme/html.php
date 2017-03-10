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
			if ($type == 'texte' || $type == 'motdepasse' || $type == 'mail' || $type == 'nombre' || $type == 'telephone')
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
				echo '" id="' . $nom . '" name="' . $nom . '" ';
				if ($type != 'motdepasse')
					echo 'value="' . $this->validateur->recupValeur($nom) . '" ';
				echo '/>';
			}
			echo '<br />';
			$erreur = $this->validateur->recupErreur($nom);
			if (!empty($erreur))
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
			echo '<label for="' . $nom . '">' . $this->validateur->recupLibelle($nom) . '</label>';
			echo '<select id="' . $nom . '" name="' . $nom . '">';
			foreach ($elements as $e)
			{
				echo '<option value="' . $e[0] . '"';
				if ($this->validateur->recupValeur($nom) == $e[0])
					echo ' selected';
				echo '>' . $e[1] . '</option>';
			}
			echo '</select>';
		}
		
		public function ouvrirFormulaire($nom, $action = '#', $methode = 'post')
		{
			$nom = 'validateur' . ucfirst($nom);
			$this->validateur = $this->controleur->$nom;
			echo '<form action="' . $action . '" method="' . $methode . '">';
		}
	}
}