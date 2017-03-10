<h1>Connexion</h1>
<?php
if ($this->session->recup('messageConnexion'))
	echo '<p>' . $this->session->recup('messageConnexion') . '</p>';
$html->ouvrirFormulaire('personnes', '#');
$html->champ('email_personnes');
$html->champ('mdp_etudiants');
$html->boutonEnvoyer('Connexion');
$html->fermerFormulaire();