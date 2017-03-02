<?php
namespace Systeme
{
	require_once('systeme/html.php');
	require_once('systeme/pagination.php');
	require_once('systeme/session.php');
	class Controleur
	{
		protected $html;
		protected $pagination;
		protected $routeur;
		protected $session;
		
		public function __construct($routeur)
		{
			$this->html = new Html($this);
			$this->pagination = new Pagination($routeur);
			$this->routeur = $routeur;
			$this->session = new Session();
		}
		
		protected function chargerModele($nomModele)
		{
			$cheminModele = 'application/modeles/' . $nomModele . '.php';
			if (file_exists($cheminModele))
			{
				require_once('systeme/modele.php');
				require_once($cheminModele);
				$nomModele = str_replace('-', '', ucwords($nomModele, '-'));
				$namespaceModele = '\App\Modeles\\'. $nomModele;
				$nomModele = lcfirst($nomModele);
				$this->$nomModele = new $namespaceModele($this->routeur->recupBDD());
			}
		}
	
		protected function chargerValidateur($nomValidateur)
		{
			$cheminValidateur = 'application/validateurs/' . $nomValidateur . '.php';
			if (file_exists($cheminValidateur))
			{
				require_once('systeme/validateur.php');
				require_once($cheminValidateur);
				$nomValidateur = str_replace('-', '', ucwords($nomValidateur, '-'));
				$nomModele = lcfirst($nomValidateur);
				$namespaceValidateur = '\App\Validateurs\\'. $nomValidateur;
				$nomValidateur = 'validateur' . $nomValidateur;
				$this->$nomValidateur = new $namespaceValidateur($this, $this->$nomModele);
			}
		}
		
		protected function chargerVue($vue = '', $params = [], $gabarit = 'defaut')
		{
			if (empty($vue))
				$vue = $this->routeur->recupNomAction();
			$cheminVue = 'application/vues/';
			if (!strpos($vue, '/'))
				$cheminVue .= $this->routeur->recupNomControleur() . '/';
			$cheminVue .= $vue . '.php';
			if (!file_exists($cheminVue))
			{
				$this->routeur->redirectionInterne('erreurs', 'erreurVue', [$vue]);
				exit();
			}
			$cheminGabarit = 'application/vues/gabarits/' . $gabarit . '.php';
			if (!file_exists($cheminGabarit))
			{
				$this->routeur->redirectionInterne('erreurs', 'erreurGabarit', [$gabarit]);
				exit();
			}
			extract($params);
			$html = $this->html;
			$pagination = $this->pagination;
			$session = $this->session;
			ob_start();
			include($cheminVue);
			$contenu = ob_get_clean();
			include($cheminGabarit);
		}
		
		public function recupSession()
		{
			return $this->session;
		}

		protected function rediriger($nomControleur = '', $nomAction = '', $params = [])
		{
			$this->routeur->rediriger($nomControleur, $nomAction, $params);
		}
		
		protected function verifierConnexion()
		{
			if (!$this->session->recup('nom_champ'))
			{
				$this->session->definir('url_temp', [$this->routeur->recupNomControleur(), $this->routeur->recupNomAction(), $this->routeur->recupParams()]);
				$this->rediriger('connexion');
			}
		}
	}
}