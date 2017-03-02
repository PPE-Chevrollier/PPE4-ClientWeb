<h1>Bienvenue sur Haricot Magique !</h1>
<h2>Dernières plantes ajoutées :</h2>
<ul>
	<?php foreach ($plantes as $plante) echo '<li><a href="/plantes/voir/' . $plante['id_plante'] . '">' . $plante['nom_plante'] . '</a></li>'; ?>
</ul><a href="/plantes">Voir toutes les plantes</a>