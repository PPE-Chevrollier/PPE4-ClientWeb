<h1>Inscription sur Haricot Magique</h1>
<?php
$html->ouvrirFormulaire('champ');
$html->champ('nom_champ');
$html->champ('mdp_champ');
$html->champ('confirmation_mdp');
$html->boutonEnvoyer('Inscription');
$html->fermerFormulaire();