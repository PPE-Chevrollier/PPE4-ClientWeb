<h1>Météo du <?php echo $date; ?></h1>
<?php
$i = 0;
foreach ($evenements as $e)
{
	if ($i > 0)
		echo ', ';
	echo $e['nom_meteo'];
	$i++;
}