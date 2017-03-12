<?php
if ($session->recup('id_personnes'))
	echo '<a id="nouveauLogement" href="/logements/nouveau">Proposer un logement</a>';
else
	echo '<p id="message">Connectez-vous pour proposer un logement.</p>';
echo '<h1>Liste des logements disponibles</a>';