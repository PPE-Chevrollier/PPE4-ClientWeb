<?php
if (!$estConnecte)
	echo '<p id="message">Connectez-vous pour proposer un logement.</p>';
echo '<h1>Liste des logements disponibles</h1>';
if ($estConnecte)
	echo '<a class="buttonDroit" href="/logements/nouveau">Proposer un logement</a>';
if (isset($villes)){
	echo '<div id="Recherche">';
	$html->ouvrirFormulaire('logements', '/logements/chercher');
	$html->listeDeroulante('ville_logements', $villes);
	$html->listeDeroulante('type_logements', ['0' => '---', '1' => 'Appartement', '2' => 'Chambre chez l\'habitant', '3' => 'Studio']);
	$html->champ('surface_logements');
	$html->champ('prix_logements');
	$html->boutonEnvoyer('Chercher');
	$html->fermerFormulaire();
	echo '</div>';
}
echo '<table id="listeLogements"><tr><th>Photo</th><th>Type</th><th>Adresse</th><th>Surface</th><th>Prix mensuel</th><th>Note moyenne</th><th>Action</th></tr>';
foreach ($logements as $l)
{
	echo '<tr class="LigneLogement" onclick="document.location = \'/logements/voir/' . $l->id_logements . '\';"><td><img src="/images/photos/' . $l->id_photos . '.' . $l->extension_photos . '" alt="' . $l->description_photos . '" width="50" height="50"></img></td>';
	switch ($l->type_logements){
		case 1:
			echo '<td>Appartement</td>';
			break;
		case 2:
			echo '<td>Chambre chez l\'habitant</td>';
			break;
		default:
			echo '<td>Studio</td>';
	}	
	echo '<td>' . $l->rue_logements . ', ';
	if (!empty($l->complement_adresse_logements))
		echo $l->complement_adresse_logements . ', ';
	echo $l->cp_logements . ' ' . $l->nom_villes . '<br /></td>';
	
	echo '<td>' . $l->surface_logements . 'm²</td><td>' . number_format($l->prix_logements, 2, ',', ' ') . '€</a></<td><td>' . (($l->note_moyenne == null) ? 'Aucune note' : number_format($l->note_moyenne, 0).'/5') . '</td>';
	if ($l->id_etudiants == $this->session->recup('id_etudiants')){
		echo '<td><a class="buttonDroit" href="/logements/modifier/' . $l->id_logements . '">Modifier</a>';
		echo '<a class="buttonDroit" style="margin-left: 10px;" href="/logements/supprimer/' . $l->id_logements . '">Supprimer</a></td>';
	}		
	else echo '<td></td>';
	echo '</td></tr>';
}	
echo '</table>';