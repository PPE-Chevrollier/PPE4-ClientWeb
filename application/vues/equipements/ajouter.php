<h1>Ajouter un équipement au logement</h1>
<?php
$html->ouvrirFormulaire('equipements', '#');
$html->champ('libelle_equipements');
$html->boutonEnvoyer('Ajouter');
$html->fermerFormulaire();