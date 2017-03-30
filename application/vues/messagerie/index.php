<h1>Boîte de réception</h1>
<a class="buttonDroit" href="/messagerie/nouveau">Nouveau message</a>
<?php if (sizeof($messages) > 0)
{
	echo '<ul>';
	foreach ($messages as $m)
	{
		echo '<li>';
		if (!$m->lu_messages)
			echo '<strong>';
		echo $m->sujet_messages . '<br />De : ';
		if ($m->sexe_personnes == 'M')
			echo 'M.';
		else
			echo 'Mme.';
		echo ' ' . $m->prenom_personnes . ' ' . $m->nom_personnes;
		if (!$m->lu_messages)
			echo '</strong>';
		echo '</li>';
	}
	echo '</ul>';
}
else
	echo '<p>Aucun message.</p>';