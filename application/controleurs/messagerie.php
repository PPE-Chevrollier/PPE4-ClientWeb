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
			$idDestinataire = (sizeof($params) > 0) ? $params[0] : 0;
			$idMessage = (sizeof($params) == 2) ? $params[1] : 0;
			$destinataire = $this->personnes->recupParId($idDestinataire);
			$message = $this->messages->recupParId($idMessage);
			if ($this->validateurMessages->nouveau())
			{
				$this->messages->ecrire($this->session->recup('id_etudiants'), $this->validateurMessages->recupValeur('destinataire_messages'), $this->validateurMessages->recupValeur('sujet_messages'), $this->validateurMessages->recupValeur('texte_messages'));
				$this->rediriger('messagerie');
			}
			else
			{
				if ($destinataire != null)
					$this->validateurMessages->definirValeur('destinataire_messages', $destinataire->login_etudiants);
				$texte = "\n" . $this->session->recup('prenom_etudiants');
				if ($message != null)
				{
					$this->validateurMessages->definirValeur('sujet_messages', 'Re : ' . $message->sujet_messages);
					$texte .= "\n" . '--- En réponse à ---' . "\n" . 'De : ';
					if ($message->sexe_personnes == 'M')
						$texte .= 'M.';
					else
						$texte .= 'Mme.';
					$texte .= ' ' . $message->prenom_personnes . ' ' . $message->nom_personnes . "\n" . 'Date : ' . date('d/m/Y', strtotime($message->date_messages)) . "\n" . 'Sujet : ' . $message->sujet_messages . "\n" . $message->texte_messages;
				}
				else
					$this->validateurMessages->definirValeur('sujet_messages', 'Demande d\'information');
				$this->validateurMessages->definirValeur('texte_messages', $texte);
				$this->chargerVue('', ['scripts' => ['messagerieNouveau'], 'titre' => 'Nouveau message']);
			}
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
				$this->chargerVue('', ['date' => $message->date_messages, 'id' => $message->id_messages, 'idAuteur' => $message->auteur_messages, 'nom' => $message->nom_personnes, 'prenom' => $message->prenom_personnes, 'sexe' => $message->sexe_personnes, 'sujet' => $message->sujet_messages, 'texte' => $message->texte_messages, 'titre' => 'Lecture d\'un message']);
			}
		}
		
		public function supprimer($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('messages');
			$idMessage = (sizeof($params) == 1) ? $params[0] : 0;
			$message = $this->messages->recupParId($idMessage);
			if ($message == null || $message->destinataire_messages != $this->session->recup('id_etudiants'))
				$this->chargerVue('introuvable', ['titre' => 'Message introuvable']);
			else
			{
				$this->messages->supprimer($idMessage);
				$this->rediriger('messagerie');
			}
		}
	}
}