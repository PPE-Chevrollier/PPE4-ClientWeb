<?php
if (!$estConnecte)
	echo '<p id="message">Connectez-vous pour proposer un logement.</p>';
echo '<h1>Liste des logements disponibles</h1>';
if ($estConnecte)
	echo '<a class="buttonDroit" href="/logements/nouveau">Proposer un logement</a>';
$html->ouvrirFormulaire('logements', '/logements/chercher');
$html->listeDeroulante('ville_logements', $villes);
$html->boutonEnvoyer('Chercher');
$html->fermerFormulaire();
echo '<ul id="listeLogements">';
foreach ($logements as $l)
{
	echo '<li><a href="/logements/voir/' . $l->id_logements . '"><img src="/images/photos/' . $l->id_photos . '.' . $l->extension_photos . '" alt="' . $l->description_photos . '" width="50" height="50"></img><span>' . $l->rue_logements . ', ';
	if (!empty($l->complement_adresse_logements))
		echo $l->complement_adresse_logements . ', ';
	echo $l->cp_logements . ' ' . $l->nom_villes . '<br />';
	if ($l->type == 1)
		echo 'Appartement';
	else if ($l->type == 2)
		echo 'Chambre chez l\'habitant';
	else
		echo 'Studio';
	echo ', ' . $l->surface_logements . 'm², ' . number_format($l->prix_logements, 2, ',', ' ') . '€/mois</span></a>';
	if ($l->id_etudiants == $this->session->recup('id_etudiants'))
		echo '<a class="buttonDroit" href="/logements/modifier/' . $l->id_logements . '">Modifier</a>';
	echo '</li>';
}	
echo '</ul>';