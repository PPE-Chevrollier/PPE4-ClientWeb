<h1>Gérer les équipements du logement</h1>
<?php echo '<a class="buttonDroit" href="/equipements/ajouter/' . $idLogement . '">Ajouter un équipement</a>';
if (sizeof($equipements) > 0)
{
	echo '<ul>';
	foreach ($equipements as $e)
		echo '<li>' . $e->libelle_equipements . ' (<a href="/equipements/supprimer/' . $idLogement . '/' . $e->id_equipements . '">Supprimer</a>)</li>';
	echo '</ul>';
}
else
	echo '<p>Aucun équipement.</p>';