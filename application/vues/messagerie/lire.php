<h1><?php echo $sujet; ?></h1>
<?php echo '<a href="/messagerie/nouveau/' . $idAuteur . '/' . $id . '">Répondre</a>';
echo '<a class="buttonDroit" href="/messagerie/supprimer/' . $id . '">Supprimer</a>'; ?>
<p>De : <?php if ($sexe == 'M')
	echo 'M.';
else
	echo 'Mme.';
echo ' ' . $prenom . ' ' . $nom; ?><br />
Le : <?php echo date('d/m/Y', strtotime($date)); ?></p>
<p><?php echo $texte; ?></p>