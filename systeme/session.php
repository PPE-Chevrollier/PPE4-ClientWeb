<?php
namespace Systeme
{
	class Session
	{
		public function definir($nom, $valeur)
		{
			$_SESSION[$nom] = $valeur;
		}
		
		public function recup($nom)
		{
			if (!isset($_SESSION[$nom]))
				return false;
			return $_SESSION[$nom];
		}
		
		public function supprimer($nom)
		{
			unset($_SESSION[$nom]);
		}
		
		public function vider()
		{
			session_destroy();
		}
	}
}