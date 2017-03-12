<h1>Modifier le profil</h1>
<?php
$html->ouvrirFormulaire('personnes', '#');
$html->champ('nom_personnes');
$html->champ('prenom_personnes');
$html->champ('email_personnes');
$html->champ('tel_personnes');
$html->listeDeroulante('sexe_personnes', ['M' => 'Homme', 'F' => 'Femme']);
echo '<fieldset><legend>Changer le mot de passe</legend>';
$html->champ('mdp_actuel');
$html->champ('mdp_etudiants');
$html->champ('confirmation_mdp');
echo '</fieldset>';
$html->boutonEnvoyer('Mettre à jour le profil');
$html->fermerFormulaire();