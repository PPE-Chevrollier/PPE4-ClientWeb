<h1>Ajouter une photo au logement</h1>
<?php
$html->ouvrirFormulaire('photos', '#');
$html->champ('photo');
$html->champ('description_photos');
$html->boutonEnvoyer('Ajouter');
$html->fermerFormulaire();