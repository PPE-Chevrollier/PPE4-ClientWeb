<?php
namespace App\Validateurs
{
	class Messages extends \Systeme\Validateur
	{
		private $personnes;
		
		public function __construct($controleur, $modele)
		{
			parent::__construct($controleur, $modele);
		}
		
		public function definirPersonnes($personnes)
		{
			$this->personnes = $personnes;
		}
		
		public function nouveau()
		{
			$this->ajouterChamp(['nom' => 'destinataire_messages', 'type' => 'texte', 'libelle' => 'Destinataire']);
			$this->ajouterChamp(['nom' => 'sujet_messages', 'type' => 'texte', 'libelle' => 'Sujet']);
			$this->ajouterChamp(['nom' => 'texte_messages', 'type' => 'texte', 'libelle' => 'Message']);
			if ($this->estValide())
			{
				$e = $this->personnes->recupParNomUtilisateur($this->recupValeur('destinataire_messages'));
				if ($e == null)
					$this->definirErreur('destinataire_messages', 'Cet étudiant n\'existe pas.');
				else
				{
					$this->definirValeur('destinataire_messages', $e->id_etudiants);
					return true;
				}
			}
			return false;
		}
	}
}