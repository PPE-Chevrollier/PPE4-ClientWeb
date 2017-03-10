<h1>Modifier le profil</h1>
<?php
$html->ouvrirFormulaire('personnes', '#');
$html->champ('nom_personnes');
$html->champ('prenom_personnes');
$html->champ('email_personnes');
$html->champ('tel_personnes');
echo '<fieldset><legend>Changer le mot de passe</legend>';
$html->champ('ancien_mdp');
$html->champ('mdp_etudiants');
$html->champ('confirmation_mdp');
echo '</legend>';
$html->boutonEnvoyer('Mettre à jour le profil');
$html->fermerFormulaire();