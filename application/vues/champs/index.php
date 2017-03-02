<h1>Liste de vos parcelles :</h1>
<?php if ($parcelles)
{
	echo '<ul>';
	foreach ($parcelles as $parcelle)
		echo '<li>' . $parcelle['nom_parcelle'] . ' (' . $parcelle['superficie_parcelle'] . 'km2)</li>';
	echo '</ul>';
}
else
	echo '<p>Vous n\'avez aucune parcelle.';