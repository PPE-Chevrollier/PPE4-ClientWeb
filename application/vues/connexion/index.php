<?php
if ($session->recup('messageConnexion'))
	echo '<p id="message">' . $session->recup('messageConnexion') . '</p>';
echo '<h1>Connexion</h1>';
$html->ouvrirFormulaire('personnes', '#');
$html->champ('email_etudiants');
$html->champ('mdp_etudiants');
$html->boutonEnvoyer('Connexion');
$html->fermerFormulaire();