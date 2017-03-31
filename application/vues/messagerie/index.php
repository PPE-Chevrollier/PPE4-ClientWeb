<h1>Boîte de réception</h1>
<a class="buttonDroit" href="/messagerie/nouveau">Nouveau message</a>
<?php if (sizeof($messages) > 0)
{
	echo '<table><thead><th><td>Sujet</td><td>Expéditeur</td><td>Date</td></th></thead><tbody>';
	foreach ($messages as $m)
	{
		echo '<tr>';
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