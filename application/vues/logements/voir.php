<h1>Consultation du logement</h1><?php
if ($idEtudiants == $this->session->recup('id_etudiants'))
	echo '<a class="buttonDroit" href="/logements/modifier/' . $idLogement . '">Modifier le logement</a>';
else
	echo '<a href="/messagerie/nouveau/' . $idEtudiants . '">Contacter</a>';
?>
<p><?php echo '<img src="/images/photos/' . $photo . '" alt="' . $descriptionPhoto . '" width="150" height="150"></img>'; ?><br />
Type : <?php if ($type == 1) echo 'Appartement'; else if ($type == 2) echo 'Chambre chez l\'habitant'; else echo 'Studio'; ?><br />
Adresse : <?php echo $rue . ', ';
if (!empty($complementAdresse))
	echo $complementAdresse . ', ';
echo $cp . ' ' . $ville; ?><br />
Proposé par : <?php if ($sexeEtudiant == 'M') echo 'M. '; else echo 'Mme.'; echo $prenomEtudiant . ' ' . $nomEtudiant; ?><br />
Propriétaire : <?php if ($sexeProprietaire == "M") echo 'M. '; else echo 'Mme. '; echo $prenomProprietaire . ' ' . $nomProprietaire; ?><br />
Surface : <?php echo $surface; ?>m²<br />
Prix : <?php echo number_format($prix, 2, ',', ' '); ?>€/mois<br />
<?php if ($type == 1)
	echo 'Nombre de places : '. $nbPlaces . '<br />Nombre de chambres : ' . $nbChambres;
else if ($type == 2)
{
	echo 'Parties communes : ';
	if ($partiesCommunes)
		echo 'Oui';
	else
		echo 'Non';
}
else if ($type == 3)
{
	echo 'Meublé : ';
	if ($meuble)
		echo 'Oui';
	else
		echo 'Non';
}
?>
</p>
<?php if (sizeof($equipements) > 0)
{
	echo '<h2>Équipements</h2><ul>';
	foreach ($equipements as $e)
		echo '<li>' . $e->libelle_equipements . '</li>';
	echo '</ul>';
}
if (sizeof($photos) > 1)
{
	echo '<h2>Autres photos</h2>';
	foreach ($photos as $p)
	{
		if ($p->id_photos != $idPhoto)
			echo '<img src="/images/photos/' . $p->id_photos . '.' . $p->extension_photos . '" alt="' . $p->description_photos . '" width="75" height="75"></img>';
	}
} ?>
<h2>Avis des étudiants</h2>
<?php if ($nbAvis == 0)
	echo '<p>Aucun avis pour le moment.</p>';
else
	echo '<p>Noté ' . number_format($noteMoyenne, 1, ',', ' ') . '/5 par ' . $nbAvis . ' étudiant(s).</p>';
if (!$aVote && $idEtudiant != $this->session->recup('id_etudiants'))
{
	$html->ouvrirFormulaire('logements', '/logements/voter/' . $idLogement);
	$html->champCache('vote');
	for ($i = 1; $i <= 5; $i++)
	{
		echo '<img class="vote" id="vote_' . $i . '" src="/images/etoile1.png" alt="' . $i . '/5"></img>';
	}
	$html->boutonEnvoyer('Voter');
	$html->fermerFormulaire();
}