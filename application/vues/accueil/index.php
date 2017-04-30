<h1>Bienvenue sur ChevLoc !</h1>
<h2>Derniers logements proposés</h2>
<?php if ($logements == null || sizeof($logements) == 0)
	echo '<p>Aucun logement.</p>';
else
{
	echo '<table id="listeLogements"><tr><th>Photo</th><th>Type</th><th>Adresse</th><th>Surface</th><th>Prix mensuel</th><th>Note moyenne</th></tr>';
	foreach ($logements as $l)
	{
		echo '<tr class="LigneLogement" onclick="document.location = \'/logements/voir/' . $l->id_logements . '\';"><td><img src="/images/photos/' . $l->id_photos . '.' . $l->extension_photos . '" alt="' . $l->description_photos . '" width="50" height="50"></img></td>';
		switch ($l->type_logements)
		{
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
		echo '</tr>';
	}	
	echo '</table>';
}