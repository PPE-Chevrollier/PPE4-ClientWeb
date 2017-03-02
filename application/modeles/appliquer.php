<?php
namespace App\Modeles
{
	class Personnes extends \Systeme\Modele
	{
		public function __construct()
		{
			$this->ajouterChamp(['nom' => 'ID_PERSONNES', 'type' => 'nombre']);
			$this->ajouterChamp(['nom' => 'ID_LOGEMENTS_PERSONNES', 'type' => 'nombre']);
			$this->ajouterChamp(['nom' => 'NOM_PERSONNES', 'type' => 'texte']);
      $this->ajouterChamp(['nom' => 'PRENOM_PERSONNES', 'type' => 'texte']);
      $this->ajouterChamp(['nom' => 'TEL_PERSONNES', 'type' => 'nombre']);
      $this->ajouterChamp(['nom' => 'EMAIL_PERSONNES', 'type' => 'texte']);
      $this->ajouterChamp(['nom' => 'ADMIN_PERSONNES', 'type' => 'nombre']);
      $this->ajouterChamp(['nom' => 'LOGIN_ETUDIANTS', 'type' => 'texte']);
      $this->ajouterChamp(['nom' => 'MDP_ETUDIANTS', 'type' => 'texte']);
      $this->ajouterChamp(['nom' => 'DATENAISS_PERSONNES', 'type' => 'texte']);
      $this->ajouterChamp(['nom' => 'SEXE_PERSONNES', 'type' => 'texte']);      
		}
	}
}