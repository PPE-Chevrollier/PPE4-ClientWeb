<h1>Liste de vos parcelles :</h1>
<?php if ($parcelles)
{
	echo '<ul>';
	foreach ($parcelles as $parcelle)
		echo '<li>' . $parcelle['nom_parcelle'] . ' : ' . $parcelle['superficie_parcelle'] . 'km2, ' . $parcelle['nom_plante'] . ' (' . ($parcelle['statutactuel_plante'] / $parcelle['statutmax_plante'] * 100) . '%)</li>';
	echo '</ul>';
}
else
	echo '<p>Vous n\'avez aucune parcelle.';
?>
<a href="/parcelles/ajouter">Ajouter une parcelle</a>