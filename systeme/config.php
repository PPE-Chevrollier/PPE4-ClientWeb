<?php
namespace Systeme
{
	class Config
	{
		private $valeurs;
		
		public function __construct()
		{
			$this->valeurs = [];
		}
		
		public function definir($cle, $valeur)
		{
			$this->valeurs[$cle] = $valeur;
		}

		public function recup($cle)
		{
			if (isset($this->valeurs[$cle]))
				return $this->valeurs[$cle];
			return "";
		}
	}
}