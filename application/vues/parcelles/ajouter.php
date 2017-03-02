<h1>Ajouter une parcelle</h1>
<?php $html->ouvrirFormulaire('parcelle');
$html->champ('nom_parcelle');
$html->champ('superficie_parcelle');
$html->listeDeroulante('id_plante', $plantes);
$html->listeDeroulante('id_terrain', $terrains);
$html->boutonEnvoyer('Ajouter');
$html->fermerFormulaire();