<?php
namespace Systeme
{
	require_once('systeme/bdd.php');
	class Modele
	{
		protected $BDD;
		
		public function __construct($bdd)
		{
			$this->BDD = $bdd;
		}
	}
}