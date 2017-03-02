<h1>Liste des plantes</h1>
<?php $pagination->afficherLiens();
echo '<ul>';
foreach ($plantes as $plante)
	echo '<li><a href="/plantes/voir/' . $plante['id_plante'] . '">' . $plante['nom_plante'] . '</a></li>';
echo '</ul>';
$pagination->afficherLiens();