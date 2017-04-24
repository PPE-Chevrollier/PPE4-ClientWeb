<h1>Boîte de réception</h1>
<a class="buttonDroit" href="/messagerie/nouveau">Nouveau message</a>
<?php if (sizeof($messages) > 0)
{
	echo '<table id="listeLogements"><tr><th>Sujet</th><th>Expéditeur</th><th>Date</th></tr>';
	foreach ($messages as $m)
	{
		echo '<tr class="LigneLogement" onclick="document.location = \'/messagerie/lire/' . $m->id_messages . '\'">';
		if (!$m->lu_messages)
			echo '<strong>';
		echo '<td>' . $m->sujet_messages . '</td><td>';
		if ($m->sexe_personnes == 'M')
			echo 'M.';
		else
			echo 'Mme.';
		echo ' ' . $m->prenom_personnes . ' ' . $m->nom_personnes . '</td><td>' . date('d/m/Y', strtotime($m->date_messages)) . '</td>';
		if (!$m->lu_messages)
			echo '</strong>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}
else
	echo '<p>Aucun message.</p>';