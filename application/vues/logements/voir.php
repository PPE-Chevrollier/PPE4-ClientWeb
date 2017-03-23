<h1>Consultation du logement</h1>
<p><img src="/images/photos/<?php echo $photo; ?>" alt="<?php echo $descriptionPhoto; ?>"></img><br />
Type : <?php if ($type == 1) echo 'Appartement'; else if ($type == 2) echo 'Chambre chez l\'habitant'; else echo 'Studio'; ?><br />
Adresse : <?php echo $rue . ', ';
if (!empty($complementAdresse))
	echo $complementAdresse . ', ';
echo $cp . ' ' . $ville; ?><br />
Proposé par : <?php if ($sexeEtudiant == 'M') echo 'M. '; else echo 'Mme.'; echo $prenomEtudiant . ' ' . $nomEtudiant; ?><br />
Propriétaire : <?php if ($sexeProprietaire == "M") echo 'M. '; else echo 'Mme. '; echo $prenomProprietaire . ' ' . $nomProprietaire; ?><br />
Surface : <?php echo $surface; ?> m2<br />
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
<h2>Avis des étudiants</h2>
<?php if ($nbAvis == 0)
	echo '<p>Aucun avis pour le moment.</p>';
else
	echo '<p>Noté ' . number_format($noteMoyenne, 1, ',', ' ') . '/5 par ' . $nbAvis . ' étudiant(s).</p>';