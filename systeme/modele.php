<?php
namespace Systeme
{
	require_once('systeme/bdd.php');
	class Modele
	{
		protected $BDD;
		private $champs;
		
		public function __construct($bdd)
		{
			$this->BDD = $bdd;
			$this->champs = [];
		}
	
		protected function ajouterChamp($champ)
		{
			$this->champs[$champ['nom']] = $champ;
		}

		private function attacherParametres($requete, $params)
		{
			foreach ($params as $nom => $valeur)
			{
				if ($this->champs[$nom]['type'] == 'texte' || $this->champs[$nom]['type'] == 'motdepasse' || $this->champs[$nom]['type'] == 'mail')
					$requete->bindValue(':' . $nom, $valeur, \PDO::PARAM_STR);
				else if ($this->champs[$nom]['type'] == 'nombre')
					$requete->bindValue(':' . $nom, $valeur, \PDO::PARAM_INT);
			}
		}
		
		public function compter()
		{
			$requete = $this->BDD->query('SELECT COUNT(*) FROM ' . strtoupper($this->recupNomTable()));
			$resultat = $requete->fetch()[0];
			$requete->closeCursor();
			return $resultat;
		}
		
		public function inserer($tuple)
		{
			if ($this->verifierChamps($tuple))
			{
				$sql = 'INSERT INTO ' . strtoupper($this->recupNomTable()) . ' (';
				$i = 0;
				foreach ($tuple as $nom => $valeur)
				{
					if ($i > 0)
						$sql .= ', ';
					$sql .= $nom;
					$i++;
				}
				$sql .= ') VALUES (';
				$i = 0;
				foreach ($tuple as $nom => $valeur)
				{
					if ($i > 0)
						$sql .= ', ';
					$sql .= ':' . $nom;
					$i++;
				}
				$sql .= ')';
				$requete = $this->BDD->prepare($sql);
				$this->attacherParametres($requete, $tuple);
				$requete->execute();
				$requete->closeCursor();
			}
		}
		
		public function recup($tuple = [], $options = [], $jointures = [])
		{
			if (count($tuple) > 0 && !$this->verifierChamps($tuple, true))
				return false;
			$sql = 'SELECT * FROM ' . strtoupper($this->recupNomTable());
			if (count($jointures) > 0)
			{
				foreach ($jointures as $champ1 => $champ2)
				{
					$champ2 = explode('.', $champ2);
					$table = strtoupper($champ2[0]);
					$sql .= ' INNER JOIN ' . $table . ' ON ' . strtoupper($this->recupNomTable()) . '.' . $champ1 . ' = ' . $table . '.' . $champ2[1];
				}
			}
			$tuple2 = [];
			if (count($tuple) > 0)
			{
				$sql .= ' WHERE ';
				$i = 0;
				foreach ($tuple as $nom => $valeur)
				{
					$nom = $this->recupEtOu($nom);
					$valeur = $this->recupConditionValeur($valeur);
					$tuple2[$nom[1]] = $valeur[1];
					if ($i > 0)
						$sql .= ' ' . $nom[0] . ' ';
					$sql .= $nom[1] . ' ' . $valeur[0] . ' :' . $nom[1];
					$i++;
				}
			}
			$tuple = $tuple2;
			if (isset($options['ordre']) && count($options['ordre']) > 0)
			{
				$sql .= ' ORDER BY ';
				$i = 0;
				foreach ($options['ordre'] as $nom => $ordre)
				{
					if ($i > 0)
						$sql .= ', ';
					$sql .= $nom . ' ';
					if ($ordre == 'croissant')
						$sql .= 'ASC';
					else if ($ordre == 'decroissant')
						$sql .= 'DESC';
					$i++;
				}
			}
			if (isset($options['limite']) && !isset($options['decalage']))
			{
				$options['decalage'] = 0;
				$sql .= ' LIMIT :decalage, :limite';
			}
			else if (isset($options['decalage']) && !isset($options['limite']))
			{
				$options['limite'] = 10;
				$sql .= ' LIMIT :decalage, :limite';
			}
			$requete = $this->BDD->prepare($sql);
			if (count($tuple) > 0)
				$this->attacherParametres($requete, $tuple);
			if (isset($options['decalage']))
				$requete->bindValue(':decalage', $options['decalage'], \PDO::PARAM_INT);
			if (isset($options['limite']))
				$requete->bindValue(':limite', $options['limite'], \PDO::PARAM_INT);
			$requete->execute();
			$resultat = $requete->fetchAll();
			$requete->closeCursor();
			return $resultat;
		}
		
		private function recupConditionValeur($texte)
		{
			$resultat = [];
			$operateur = explode(' ', $texte)[0];
			if ($operateur != '=' && $operateur != '<>' && $operateur != '<' && $operateur != '<=' && $operateur != '>' && $operateur != '>=')
				$operateur = '=';
			else
				$texte = substr($texte, strlen($operateur));
			array_push($resultat, $operateur);
			array_push($resultat, $texte);
			return $resultat;
		}

		private function recupEtOu($texte)
		{
			$resultat = [];
			$logique = explode(' ', $texte)[0];
			if ($logique == 'et')
			{
				$logique = 'AND';
				$texte = substr($texte, 3);
			}
			else if ($logique == 'ou')
			{
				$logique = 'OR';
				$texte = substr($texte, 3);
			}
			else
				$logique = 'AND';
			array_push($resultat, $logique);
			array_push($resultat, $texte);
			return $resultat;
		}
		
		public function recupNomTable()
		{
			$nom = (new \ReflectionClass($this))->getShortName();
			$nom2 = $nom[0];
			for ($i = 1; $i < strlen($nom); $i++)
			{
				if (strtoupper($nom[$i]) === $nom[$i])
					$nom2 .= '_';
				$nom2 .= $nom[$i];
			}
			return $nom2;
		}
		
		public function recupType($nom)
		{
			if (!isset($this->champs[$nom]['type']))
				return null;
			return $this->champs[$nom]['type'];
		}
		
		private function verifierChamps($tuple)
		{
			foreach ($tuple as $nom => $valeur)
			{
				if (!isset($this->champs[$nom]))
					return false;
			}
			return true;
		}
	}
}