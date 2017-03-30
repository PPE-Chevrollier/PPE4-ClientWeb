<?php
namespace App\Controleurs
{
	class Messagerie extends \Systeme\Controleur
	{
		public function nouveau($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('messages');
			$this->chargerValidateur('messages');
			$this->validateurMessages->definirPersonnes($this->chargerModele('personnes'));
			if ($this->session->recup('destinataire'))
				$this->validateur->definirValeur('destinataire_messages', $this->session->recup('destinataire'));
			if ($this->validateurMessages->nouveau())
			{
				$this->messages->ecrire($this->session->recup('id_etudiants'), $this->validateurMessages->recupValeur('destinataire_messages'), $this->validateurMessages->recupValeur('sujet_messages'), $this->validateurMessages->recupValeur('texte_messages'));
				//$this->rediriger('messagerie');
			}
			else
				$this->chargerVue('', ['titre' => 'Nouveau message']);
		}
		
		public function index()
		{
			$this->chargerService('connexion');
			$this->chargerModele('messages');
			$messages = $this->messages->recupParEtudiant($this->session->recup('id_etudiants'));
			$this->chargerVue('', ['messages' => $messages, 'titre' => 'Boîte de réception']);
		}
		
		public function lire($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('messages');
			$idMessage = (sizeof($params) == 1) ? $params[0] : 0;
			$message = $this->messages->recupParId($idMessage);
			if ($message == null || $message->destinataire_messages != $this->session->recup('id_etudiants'))
				$this->chargerVue('introuvable', ['titre' => 'Message introuvable']);
			else
			{
				$this->messages->lire($idMessage);
				$this->chargerVue('', ['nom' => $message->nom_personnes, 'prenom' => $message->prenom_personnes, 'sexe' => $message->sexe_personnes, 'sujet' => $message->sujet_messages, 'texte' => $message->texte_messages, 'titre' => 'Lecture d\'un message']);
			}
		}
	}
}