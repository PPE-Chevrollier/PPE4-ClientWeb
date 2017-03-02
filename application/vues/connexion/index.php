<h1>Connexion</h1>
<?php
if ($this->session->recup('inscrit'))
	echo '<p>Votre compte a bien été créé.<br />Veuillez maintenant vous connecter.</p>';
$html->ouvrirFormulaire('champ', '#');
$html->champ('nom_champ');
$html->champ('mdp_champ');
$html->boutonEnvoyer('Connexion');
$html->fermerFormulaire();