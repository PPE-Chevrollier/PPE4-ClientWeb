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
				if (isset($this->$nomModele))
					return $this->$nomModele;
				$namespaceModele = '\App\Modeles\\'. $nomModele;
				$nomModele = lcfirst($nomModele);
				$this->$nomModele = new $namespaceModele($this->routeur->recupBDD());
				return $this->$nomModele;
			}
		}

		protected function chargerService($nomService)
		{
			$cheminService = 'application/services/' . $nomService . '.php';
			if (file_exists($cheminService))
			{
				require_once('systeme/service.php');
				require_once($cheminService);
				$nomService = str_replace('-', '', ucwords($nomService, '-'));
				$namespaceService = '\App\Services\\'. $nomService;
				$nomService = 'service' . $nomService;
				$this->$nomService = new $namespaceService($this->routeur, $this->session);
				foreach ($this->$nomService->recupModeles() as $m)
					$this->$nomService->definirModele($m, $this->chargerModele($m));
				$this->$nomService->traiter();
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
	}
}