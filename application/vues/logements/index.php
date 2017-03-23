<?php
if ($estConnecte)
	echo '<a id="nouveauLogement" href="/logements/nouveau">Proposer un logement</a>';
else
	echo '<p id="message">Connectez-vous pour proposer un logement.</p>';
echo '<h1>Liste des logements disponibles</h1>';
$html->ouvrirFormulaire('logements', '/logements/chercher');
$html->listeDeroulante('ville_logements', $villes);
$html->boutonEnvoyer('Chercher');
$html->fermerFormulaire();
echo '<ul>';
foreach ($logements as $l)
{
	echo '<li><a href="/logements/voir/' . $l->id_logements . '"><img src="/images/photos/' . $l->id_photos . '.' . $l->extension_photos . '" alt="' . $l->description_photos . '" width="50" height="50"></img>' . $l->rue_logements . ', ';
	if (!empty($l->complement_adresse_logements))
		echo $l->complement_adresse_logements . ', ';
	echo $l->cp_logements . ' ' . $l->nom_villes . '</a></li>';
}	
echo '</ul>';