<h1>Météo de la semaine</h1>
<ul>
<?php
foreach ($jours as $d => $j)
{
	$i = 0;
	$evenements = '';
	foreach ($j as $e)
	{
		if ($i > 0)
			$evenements .= ', ';
		$evenements .= $e['nom_meteo'];
		$i++;
	}
	if (empty($evenements))
		$evenements = 'Rien à signaler';
	echo '<li><a href="/meteo/voir/' . $d . '">' . $d . ' : ' . $evenements . '</a></li>';
}
?>
</ul>