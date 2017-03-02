<?php
namespace Systeme
{
	class Pagination
	{
		private $nbPages;
		private $page;
		private $urlBase;
		
		public function __construct($routeur)
		{
			$this->urlBase = '/' . $routeur->recupNomControleur() . '/' . $routeur->recupNomAction();
			$params = $routeur->recupParams();
			$nbParams = count($params);
			if ($nbParams > 0)
			{
				$this->definirPage($params[$nbParams - 1] - 1);
				if ($nbParams > 1)
				{
					array_pop($params);
					$this->urlBase .= implode('/', $params);
				}
			}
		}
		
		public function afficherLiens()
		{
			if ($this->page < 0)
				$this->page = 0;
			else if ($this->page >= $this->nbPages)
				$this->page = $this->nbPages - 1;
			echo '<p class="pages">Pages :';
			if ($this->page > 0)
				echo '<a href="' . $this->urlBase . '/1">Première</a><a href="' . $this->urlBase . '/' . $this->page . '">Précédente</a>';
			for ($i = max(0, $this->page - 5); $i < min($this->nbPages, $this->page + 5); $i++)
			{
				if ($i != $this->page)
					echo '<a href="' . $this->urlBase . '/' . ($i + 1) . '">';
				echo $i + 1;
				if ($i != $this->page)
					echo '</a>';
			}
			if ($this->page + 1 < $this->nbPages)
				echo '<a href="' . $this->urlBase . '/' . ($this->page + 2) . '">Suivante</a><a href="' . $this->urlBase . '/' . $this->nbPages . '">Dernière</a>';
			echo '</p>';
		}
		
		public function definirNbElements($nbElements)
		{
			$this->nbPages = $nbElements - $nbElements % 10 + 1;
		}
		
		public function definirPage($page)
		{
			$this->page = $page;
		}
		
		public function recupNbPages()
		{
			return $this->nbPages;
		}
		
		public function recupPage()
		{
			return $this->page;
		}
	}
}