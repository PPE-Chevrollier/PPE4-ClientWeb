<h1><?php echo $sujet; ?></h1>
<p>De : <?php if ($sexe == 'M')
	echo 'M.';
else
	echo 'Mme.';
echo $prenom . ' ' . $nom; ?><br />
Date : <?php echo $date; ?></p>
<p><?php echo $texte; ?></p>