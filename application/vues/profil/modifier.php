<h1>Modifier le profil</h1>
<?php
$html->ouvrirFormulaire('personnes', '#');
$html->champ('nom_etudiants');
$html->champ('prenom_etudiants');
$html->champ('email_etudiants');
$html->champ('tel_etudiants');
$html->listeDeroulante('sexe_etudiants', ['M' => 'Homme', 'F' => 'Femme']);
echo '<fieldset><legend>Changer le mot de passe</legend>';
$html->champ('mdp_actuel');
$html->champ('mdp_etudiants');
$html->champ('confirmation_mdp');
echo '</fieldset>';
$html->boutonEnvoyer('Mettre à jour le profil');
$html->fermerFormulaire();