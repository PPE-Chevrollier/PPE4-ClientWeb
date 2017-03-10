<?php
namespace Systeme
{
	require_once('systeme/bdd.php');
	require_once('systeme/controleur.php');
	require_once('application/controleurs/erreurs.php');
	class Routeur
	{
		private $bdd;
		private $config;
		private $nomAction;
		private $nomControleur;
		private $params;

		public function __construct($config, $url)
		{
			try
			{
				$this->bdd = (new BDD($config))->recup();
			}
			catch (Exception $ex)
			{
				$this->nomControleur = 'erreurs';
				$this->nomAction = 'erreurBDD';
				$this->redirectionInterne('erreurs', 'erreurBDD');
				exit();
			}
			$url = explode('/', $url);
			if (count($url) > 0 && !empty($url[0]))
				$nomControleur = $url[0];
			else
				$nomControleur = 'accueil';
			array_shift($url);
			if (count($url) > 0 && !empty($url[0]))
				$nomAction = $url[0];
			else if ($nomControleur == 'erreurs')
				$nomAction = 'erreurControleur';
			else
				$nomAction = 'index';
			array_shift($url);
			$this->redirectionInterne($nomControleur, $nomAction, $url);
		}
		
		public function recupBDD()
		{
			return $this->bdd;
		}
		
		public function recupConfig()
		{
			return $this->config;
		}
		
		public function recupNomAction()
		{
			return $this->nomAction;
		}
	
		public function recupNomControleur()
		{
			return $this->nomControleur;
		}
		
		public function recupParams()
		{
			return $this->params;
		}

		public function redirectionInterne($nomControleur, $nomAction, $params = [])
		{
			if (empty($nomControleur))
				$nomControleur = 'accueil';
			if (empty($nomAction))
				$nomAction = 'index';
			$cheminControleur = 'application/controleurs/' . $nomControleur . '.php';
			$this->nomControleur = $nomControleur;
			$nomControleur = str_replace('-', '', ucwords($nomControleur, '-'));
			$nomAction = lcfirst(str_replace('-', '', ucwords($nomAction, '-')));
			if (!file_exists($cheminControleur))
			{
				$this->nomControleur = 'erreurs';
				$this->nomAction = 'erreurControleur';
				(new \App\Controleurs\Erreurs($this))->erreurControleur([$nomControleur]);
				exit();
			}
			require_once($cheminControleur);
			$controleur = '\App\Controleurs\\' . $nomControleur;
			$this->nomAction = $nomAction;
			$this->params = $params;
			$controleur = new $controleur($this);
			if (!method_exists($controleur, $nomAction))
			{
				$this->nomControleur = 'erreurs';
				$this->nomAction = 'erreurAction';
				(new \App\Controleurs\Erreurs($this))->erreurAction([$nomControleur, $nomAction]);
				exit();
			}
			$controleur->$nomAction($params);
		}

		public function rediriger($nomControleur = '', $nomAction = '', $params = [])
		{
			if (empty($nomControleur))
				$nomControleur = 'accueil';
			if (empty($nomAction))
				$nomAction = 'index';
			$url = '';
			if (count($params) > 0)
				$url .= '/' . implode('/', $params);
			if (!empty($url) || $nomAction != 'index')
				$url = '/' . $nomAction . $url;
			if (!empty($url) || $nomControleur != 'accueil')
				$url = $nomControleur . $url;
			header('Location: /' . $url);
		}
	}
}